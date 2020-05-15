console.log('Building css...');
const fs = require('fs-extra');
const sass = require('node-sass');
var shell = require("shelljs");     //执行shell
var watch = require('watch');       //监测目录变化

watch.watchTree('./build/css', function (f, curr, prev) {
    console.log(2);
});

let build = {
    isDir:function(filePath){
        let stat = fs.lstatSync(filePath);
        return stat;
    },
    created:function(){
        let dir = this.isDir('css/test.scss');
        console.log(fs);
    },
};


