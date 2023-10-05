### Generating a .POT file
> npm run pot

### Optimizing images
> tinypng -r -k your_api_key_here
 
### Minifying files
> npm run min:js
\
> npm run min:css (this command will also concat files from the /front/ folder into front.css)

### Minify + generate pot
> npm run wpchill


### Generating a ZIP
> npm run plugin-zip


#### Assumptions:
- wp-cli is installed globally\
- tinypng.com account (free API key is sufficent for image optimization)\

