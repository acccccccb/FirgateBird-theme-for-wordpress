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
                let filePath = './'+arr.join('/');
                let fileName = arr[arr.length-1];
                // 判断文件名是否以_开头，如果是 则重新编译所有的scss文件
                if(fileName.indexOf('_')==0) {
                    build.methods.buildingCss();
                } else {
                    build.methods.scssToCss(filePath,config.exportCss);
                }
            }
        });
        watch('./src',{
            recursive: true,
            filter: /\.php$/,
        }, function(event, name) {
            console.log(event);
            console.log(name);
            let arr = name.split('\\');
            let filePath = './'+arr.join('/');
            if(event == 'update') {
                fs.copy(filePath, './dist/',{ filter: function(){
                        let reg = new RegExp(/^[^.]+$|\.(?!(tiff|tif|psd|thumb)$)([^.]+$)/); //自己的匹配规则
                        if (reg.test(name)) {
                            return true; //通过过滤条件，该目录允许复制到dest目录
                        } else {
                            console.log('ignore:'+ src);
                            return false; //丢弃，不复制到dest目录
                        };
                    }})
                    .then(() => console.log('copy img success!'))
                    .catch(err => console.error(err))
            }
            if(event == 'remove') {

            }
        });
    },
};
dev.init();
