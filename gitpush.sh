#!/bin/bash
dt=$(date '+%Y-%m-%d-%H-%M-%S');

git add *
git commit -a -m "$dt"
git push origin main