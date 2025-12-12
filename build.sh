#!/bin/bash

# Create the dist directory if it doesn't exist
mkdir -p ./dist

# Process PHP files and output HTML
php index.php > ./dist/index.html
php success.php > ./dist/success.html
# Add similar lines for other pages
cp -r assets ./dist/assets
