'use strict';
const { config,srcPath,distPath } = require('./config');
const { build } = require('./build');
const sass = require('node-sass');
const watch = require('node-watch');
const fs = require('fs-extra');
const colors = require('colors');
console.log('Watching...'.green);
let dev = {
    init:function(){
        watch(config.scss,{
            recursive: true,
            filter: /\.scss$/,
        }, function(event, name) {
            let arr = name.split('\\');
            let filePath = './'+arr.join('/');
            let fileName = arr[arr.length-1];
            // 判断文件名是否以_开头，如果是 则重新编译所有的scss文件
            if(fileName.indexOf('_')==0) {
                build.methods.buildingCss();
            } else {
                build.methods.scssToCss(filePath,config.exportCss);
            }
        });
        watch(config.jsPath,{
            recursive: true,
            filter: /\.js$/,
        }, function(event, name) {
            let arr = name.split('\\');
            let input = './'+arr.join('/');
            let outPut = input.replace(config.jsPath,config.exportJs);
            outPut = outPut.substr(0,outPut.length-3) + '.min.js';
            build.methods.jsToMinJs(input,outPut);
        });
        watch('./src',{
            recursive: true,
            filter: /\.php$/,
        }, function(event, name) {
            let arr = name.split('\\');
            let filePath = './'+arr.join('/');
            let outPut = filePath.replace(srcPath,distPath);
            let now = new Date();
            if(event == 'update') {
                const data = fs.readFileSync(filePath, 'utf8');
                fs.outputFile(outPut, data, function(err) {
                    if(!err) {
                        console.log(event+':' + outPut.green);
                    } else {
                        console.log(err.red);
                    }
                });
            }
            if(event == 'remove') {
                fs.remove(outPut).then(()=>{
                    console.log(event+':' + outPut.green);
                }).catch(e=>{console.log(e.red)});
            }
        });
    },
};
dev.init();
