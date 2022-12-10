<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

use Yii;
use yii\db\Query;
use yii\db\Expression;

/**
 * Define the number of blocks that should be read from the source file for each chunk.
 * For 'AES-128-CBC' each block consist of 16 bytes.
 * So if we read 10,000 blocks we load 160kb into memory. You may adjust this value
 * to read/write shorter or longer chunks.
 */
define('FILE_ENCRYPTION_BLOCKS', 10000);

/**
 * Description of SeleccionHelper
 *
 * @author jairo-bernal
 */
class SeleccionHelper {

    /**
     * 
     * @param string $archivotemporal
     * @param string $identificacion
     * @param \common\models\ArchivoAspirante $model
     * @param string $extension
     * @return type
     */
    public static function creaArchivoAspirante($archivotemporal, $identificacion, $nombrearchivo, $model = null, $extension = '.pdf') {
        //$nombrearchivo = $identificacion . '_' . Yii::$app->security->generateRandomString();
        if (!is_null($model)) {
            $model->uuid = static::uuid();
            $model->ruta_web = Yii::$app->params['rutaarchivosaspirantes'] .
                    DIRECTORY_SEPARATOR .
                    substr($identificacion, 0, 3) .
                    DIRECTORY_SEPARATOR .
                    $identificacion .
                    DIRECTORY_SEPARATOR .
                    $nombrearchivo;
        }
        /* Si no existen los subdirectorios entonces se crean y se crean los archivos index.php */
        Yii::$app->params['uploadPath'] = Yii::$app->basePath .
                DIRECTORY_SEPARATOR .
                'web' .
                Yii::$app->params['rutaarchivosaspirantes'] .
                DIRECTORY_SEPARATOR;
        $path1 = static::creaDirectorio(Yii::$app->params['uploadPath'] . substr($identificacion, 0, 3));
        static::copiaArchivoSiNoExiste($path1 . DIRECTORY_SEPARATOR . 'index.php', Yii::$app->params['uploadPath'] . 'index.php');
        $ruta = static::creaDirectorio($path1 . DIRECTORY_SEPARATOR . $identificacion) . DIRECTORY_SEPARATOR;
        static::copiaArchivoSiNoExiste($ruta . 'index.php', Yii::$app->params['uploadPath'] . 'index.php');
        /* Se terminó de verificar que existan los directorios y que tengan archivo index.php */
        /* Se crea la ruta completa donde se almacenará el archvo cargado */
        $path = $ruta . $nombrearchivo;
        if ($extension == '.pdf') {
            exec('/usr/local/bin/gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile="' . $archivotemporal . $extension . '" "' . $archivotemporal . '"');
        } else {
            copy($archivotemporal, $archivotemporal . $extension);
        }
        // https://www.webniraj.com/2018/08/15/dynamically-adding-passwords-to-pdfs-using-php/
        /* try {
          $pdf = new PasswordProtectPDF($archivotemporal . '.pdf', "s63ITBCalq8v");
          // render the PDF inline (i.e. within browser where supported)
          $pdf->setTitle($model->aspirante_uuid)->output('F', $archivotemporal . '_new.pdf');
          unlink($archivotemporal . '.pdf');
          } catch (\Exception $e) {
          // catch any errors in rendering the PDF
          if ($e->getCode() == 267) {
          return ['resultado' => false, 'error' => 'El PDF cargado tiene formato de compresión no soportado. Imprímalo sin compresión.'];
          }
          return ['resultado' => false, 'error' => 'No se pudo procesar el PDF cargado. Intente con otra versión del archivo.'];
          }/* */
        /* Se cifra el archivo y se guarda en la ruta definida */
        if (static::encryptFile($archivotemporal . $extension, Yii::$app->params['cipherkey'], $path) == false) {
            return ['resultado' => false, 'error' => 'Ocurrió un error al guardar el archivo en el servidor. Intente de nuevo.'];
            ;
        }
        unlink($archivotemporal . $extension);
        if (!is_null($model)) {
            if ($model->validate() && $model->save()) {
                return ['resultado' => true];
            } else {
                return ['resultado' => false, 'error' => print_r($model->getErrors())];
            }
        } else {
            return ['resultado' => true];
        }
    }

    /**
     * Copia un archivo si el destino no existe
     * 
     * @param string $path
     * @param string $pathOrigen
     */
    public static function copiaArchivoSiNoExiste($path, $pathOrigen) {
        if (!file_exists($path)) {
            copy($pathOrigen, $path);
        }
    }

    /**
     * Crea un directorio y devuelve la ruta
     * 
     * @param string $path
     * @return string
     */
    public static function creaDirectorio($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

    /**
     * Encrypt the passed file and saves the result in a new file with ".enc" as suffix.
     * https://riptutorial.com/php/example/25499/symmetric-encryption-and-decryption-of-large-files-with-openssl
     * 
     * @param string $source Path to file that should be encrypted
     * @param string $key    The key used for the encryption
     * @param string $dest   File name where the encryped file should be written to.
     * @return string|false  Returns the file name that has been created or FALSE if an error occured
     */
    public static function encryptFile($source, $key, $dest) {
        $key = substr(sha1($key, true), 0, 16);
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            // Put the initialzation vector to the beginning of the file
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) {
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    /**
     * Dencrypt the passed file and saves the result in a new file, removing the last 4 characters from file name.
     * https://riptutorial.com/php/example/25499/symmetric-encryption-and-decryption-of-large-files-with-openssl
     * 
     * @param string $source Path to file that should be decrypted
     * @param string $key    The key used for the decryption (must be the same as for encryption)
     * @param string $dest   File name where the decryped file should be written to.
     * @return string|false  Returns the file name that has been created or FALSE if an error occured
     */
    public static function decryptFile($source, $key, $dest) {
        $key = substr(sha1($key, true), 0, 16);

        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                // Get the initialzation vector from the beginning of the file
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) {
                    $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1)); // we have to read one block more for decrypting than for encrypting
                    $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $plaintext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $dest;
    }

    /**
     * Crea un uuid a partir de la función de la base de datos
     * 
     * @return string
     */
    public static function uuid() {
        return (new Query)->select(new Expression('UUID();'))->scalar();
    }

    /**
     * This function returns the maximum files size that can be uploaded 
     * in PHP
     * @returns int File size in bytes
     * */
    public static function maximumFileUploadSize() {
        return min(static::convertPHPSizeToBytes(ini_get('post_max_size')), static::convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
     * 
     * @param string $sSize
     * @return integer The value in bytes
     */
    static function convertPHPSizeToBytes($sSize) {
        //
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int) $sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
            // Fallthrough intended
            case 'T':
                $iValue *= 1024;
            // Fallthrough intended
            case 'G':
                $iValue *= 1024;
            // Fallthrough intended
            case 'M':
                $iValue *= 1024;
            // Fallthrough intended
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int) $iValue;
    }

}
