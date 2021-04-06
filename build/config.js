let distPath = 'E:\\test-project\\wordpress\\wp-content\\themes\\FirgateBird';
let srcPath = './src';
let config = {
    scss:srcPath + '/static/scss/',
    exportCss:distPath + '/static/css/',
    phpPath:srcPath + '/',
    jsPath:srcPath + '/static/js/',
    exportJs:distPath + '/static/js/',
};
module.exports = {
    config,distPath,srcPath
};
