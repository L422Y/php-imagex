# php-imagex

## What is this?
This is just a quick bit of demo code I wrote in a few hours. I don't have a lot of PHP code that I am legally allowed to distribute / show off, so I created this little kit.

## What does it do?
It takes an array of image filenames and runs them through an array of custom pixel filters.

### What is where
`www` => should be your document root
`src` => all non-client facing php

### Disclaimer:

If you're going to use *any* of this in a production environment, please consider:
 - Processing the images using parallel processing
 - Cache the results
 - Load, process and destroy the images one by one, instead of loading them all into memory
 
