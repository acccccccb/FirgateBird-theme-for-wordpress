'use strict';
const { config,distPath,srcPath } = require('./config');
const sass = require('node-sass');
const fs = require('fs-extra');
const colors = require('colors');
const uglifyEs = require('uglify-es');

let build = {
    init(){
        this.methods.copyFile(()=>{
            this.methods.copyPhp();
            this.methods.buildingCss();
            this.methods.buildingJs();
        });
    },
    methods:{
        copyPhp(){
            let _this = this;
            let loop = function(path){
                fs.readdir(path).then((res)=>{
                    res.forEach((item)=>{
                        let sourceFolder = path+item;
                        let newFolder = sourceFolder.replace(config.phpPath,'');
                        if(_this.isDir(path + item)) {
                            if(item.indexOf('static')==-1) {
                                fs.ensureDir(distPath + '/'+newFolder)
                                    .then(() => {})
                                    .catch(err => {
                                        console.error(err.red);
                                        return false;
                                    });
                                loop(path + item + '/');
                            }
                        } else {
                            fs.copy(sourceFolder, distPath + '/' + newFolder)
                                .then(() => {
                                    console.log(('copy:' + sourceFolder).green);
                                })
                                .catch(err => console.error(err.red))
                        }
                    });
                }).catch((e)=>{
                    console.log(e.toString().red);
                    return false;
                });
            };
            loop(config.phpPath);
        },
        copyFile(callback){
            fs.remove(distPath + '/static')
                .then(() => {
                    fs.copy('./static/plug-in', distPath + '/static/plug-in',{ filter: this.filterFunc })
                        .then(() => console.log('copy ./static/plug-in'.green))
                        .catch((err) => console.error(err.red));
                    fs.copy('./static/img', distPath + '/static/img',{ filter: this.filterFunc })
                        .then(() => console.log('copy ./static/img'.green))
                        .catch(err => console.error(err.red));
                    if(callback && typeof callback === 'function') {
                        callback();
                    }
                })
                .catch(err => {
                    console.error(err)
                })
        },
        jsToMinJs(input,outPut){
            let obj = {};
            obj[outPut] = fs.readFileSync(input, "utf8");
            fs.writeFile(outPut, uglifyEs.minify(obj).code, "utf8").then(()=>{
                console.log(('compress:' + outPut).green);
            });
        },
        buildingJs(){
            let _this = this;
            fs.remove(config.exportJs).then(()=>{
                fs.ensureDir(config.exportJs)
                    .then(() => {
                        let loop = function(path){
                            fs.readdir(path).then((res)=>{
                                res.forEach((item)=>{
                                    let input = path+item;
                                    let outPut = input.replace(config.jsPath,config.exportJs);
                                    outPut = outPut.substring(0,outPut.length-3) + '.min.js';
                                    if(_this.isDir(path + item)) {
                                        if(item.indexOf('static')==-1) {
                                            fs.ensureDir(outPut)
                                                .then(() => {})
                                                .catch(err => {
                                                    console.error(err);
                                                    return false;
                                                });
                                            loop(path + item + '/');
                                        }
                                    } else {
                                        fs.ensureDir(config.exportJs).then(()=>{
                                            _this.jsToMinJs(input,outPut);
                                        }).catch(e=>{console.log(e)});
                                    }
                                });
                            }).catch((e)=>{
                                console.log(e.toString());
                                return false;
                            });
                        };
                        loop(config.jsPath);
                        fs.copy('./node_modules/bootstrap/dist/js/bootstrap.min.js', config.exportJs + 'bootstrap.min.js',{ filter: this.filterFunc })
                            .then(() => console.log('copy:./node_modules/bootstrap/dist/js/bootstrap.min.js'.green))
                            .catch(err => console.error(err));
                        fs.copy('./node_modules/jquery/dist/jquery.min.js', config.exportJs + 'jquery.min.js',{ filter: this.filterFunc })
                            .then(() => console.log('copy:./node_modules/jquery/dist/jquery.min.js'.green))
                            .catch(err => console.error(err));
                        fs.copy('./node_modules/vue/dist/vue.min.js', config.exportJs + 'vue.min.js',{ filter: this.filterFunc })
                            .then(() => console.log('copy:./node_modules/vue/dist/vue.min.js'.green))
                            .catch(err => console.error(err));
                    })
                    .catch(err => {
                        console.error(err);
                        return false;
                    });
            }).catch(e=>{console.log(e)})
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
                            console.log(('compress-error:' + input).red);
                        } else {
                            console.log(('compress:' + outPut + fileName + `.min.css`).green);
                        }
                    });
                } else {
                    console.log(('compress-error:' + input).red);
                }
            })
        },
        buildingCss(){
            fs.ensureDir(config.exportCss).then(()=>{
                fs.readdir(config.scss).then((res)=>{
                    res.forEach(item=>{
                        if(!this.isDir(config.scss + item)) {
                            this.scssToCss(config.scss + item,config.exportCss);
                        } else {
                            if(item.indexOf('_')!==0) {
                                fs.ensureDir(config.exportCss + item);
                            }
                        }
                    });
                    // copy bootstrap
                    fs.copy('./node_modules/bootstrap/dist/fonts', distPath + '/static/fonts',{ filter: this.filterFunc })
                        .then(() => console.log('copy ./node_modules/bootstrap/dist/fonts'.green))
                        .catch(err => console.error(err.red));
                    fs.copy('./node_modules/bootstrap/dist/css/bootstrap.min.css', config.exportCss + 'bootstrap.min.css',{ filter: this.filterFunc })
                        .then(() => console.log('copy ./node_modules/bootstrap/dist/css/bootstrap.min.css'.green))
                        .catch(err => console.error(err.red));
                }).catch((e)=>{
                    console.log(e.toString().red);
                });
            });
        },
        filterFunc(src, dest){
            let reg = new RegExp(/^[^.]+$|\.(?!(tiff|tif|psd|thumb)$)([^.]+$)/); //自己的匹配规则
            if (reg.test(src)) {
                return true; //通过过滤条件，该目录允许复制到dist目录
            } else {
                console.log(('ignore:'+ src).gray);
                return false; //丢弃，不复制到dist目录
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






