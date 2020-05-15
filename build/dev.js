'use strict';
const { config } = require('./config');
const { build } = require('./build');
const sass = require('node-sass');
const watch = require('node-watch');
const fs = require('fs-extra');
console.log('Watching...');
let dev = {
    init:function(){
        watch(config.scss,{
            recursive: true,
            filter: /\.scss$/,
        }, function(event, name) {
            if(event == 'update') {
                let arr = name.split('\\');
                let filePath = arr.join('/');
                let fileName = arr[arr.length-1];
                // 判断文件名是否以_开头，如果是 则重新编译所有的scss文件
                if(fileName.indexOf('_')==0) {
                    build.methods.buildingCss();
                } else {
                    build.methods.scssToCss('./' + filePath,config.exportCss);
                }
            }
        });
        watch('./static',{
            recursive: true,
        }, function(event, name) {
            console.log(event);
            if(event == 'update') {

            }
        });
    },
};
dev.init();
