'use strict';
const { config } = require('./config');
const sass = require('node-sass');
const fs = require('fs-extra');

let build = {
    init(){
        this.methods.copyFile();
        this.methods.buildingCss();
    },
    methods:{
        copyFile(){
            fs.remove('./dist/static/plug-in')
                .then(() => {
                    fs.copy('./static/plug-in', './dist/static/plug-in',{ filter: this.filterFunc })
                        .then(() => console.log('copy plug-in success!'))
                        .catch(err => console.error(err))
                })
                .catch(err => {
                    console.error(err)
                })
            fs.remove('./dist/static/fonts')
                .then(() => {
                    fs.copy('./node_modules/bootstrap-sass/assets/fonts/bootstrap', './dist/static/fonts/bootstrap',{ filter: this.filterFunc })
                        .then(() => console.log('copy fonts success!'))
                        .catch(err => console.error(err))
                })
                .catch(err => {
                    console.error(err)
                })

            fs.remove('./dist/static/img')
                .then(() => {
                    fs.copy('./static/img', './dist/static/img',{ filter: this.filterFunc })
                        .then(() => console.log('copy img success!'))
                        .catch(err => console.error(err))
                })
                .catch(err => {
                    console.error(err)
                })
        },
        scssToCss(input,outPut){
            // @param input 输入文件路径
            // @param outPut 输出文件保存的位置 不要带文件名
            input.replace('\\','/');
            let arr = input.split('/');
            let fileName = arr[arr.length-1];
            let arr2 = arr[arr.length-1].split('.');
            let fileType = arr2[arr2.length-1];
            fileName = fileName.replace('.'+fileType,'');
            sass.render({
                file:input,
                options:{
                    sourceMap: true,
                    outFile: outPut + fileName + `.min.map`,
                },
            },(err,result)=>{
                if(!err) {
                    fs.writeFile(outPut + fileName + `.min.css`,result.css,function(error){
                        if(error) {
                            console.log('compress-error:' + input);
                        } else {
                            console.log('compress-success:' + outPut + fileName + `.min.css`);
                        }
                    });
                } else {
                    console.log('compress-error:' + input);
                }
            })
        },
        buildingCss(){
            fs.readdir(config.scss).then((res)=>{
                res.forEach(item=>{
                    if(!this.isDir(config.scss + item)) {
                        this.scssToCss(config.scss + item,config.exportCss);
                    }
                });
            }).catch((e)=>{
                console.log(e.toString());
            });

        },
        filterFunc(src, dest){
            let reg = new RegExp(/^[^.]+$|\.(?!(tiff|tif|psd|thumb)$)([^.]+$)/); //自己的匹配规则
            if (reg.test(src)) {
                return true; //通过过滤条件，该目录允许复制到dest目录
            } else {
                console.log('ignore:'+ src);
                return false; //丢弃，不复制到dest目录
            };
        },
        isDir:function(filePath){
            let stat = fs.lstatSync(filePath);
            return stat.isDirectory();
        },
    }
};
if(process.argv && process.argv.length>=3 && process.argv[2]=='--start') {
    build.init();
}
module.exports = {
    build
};






