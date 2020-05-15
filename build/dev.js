process.stdout.write('\n');
console.log('Watching scss...');
const sass = require('node-sass');
const watch = require('node-watch');
const fs = require('fs-extra');
let dev = {
    created:function(){
        watch('./css/scss',{
            recursive: true,
            filter: /\.scss$/,
        }, function(event, name) {
            if(event == 'update') {
                let input = name;
                let output = name.replace('.scss');
                let map = output+'.map';
                sass.render({
                    file:`${input}`,
                    options:{
                        sourceMap: true,
                        outFile:`${output}`,
                    },
                },(err,result)=>{
                    if(!err) {
                        fs.writeFile(`./${output}`,result.css,function(error){
                            if(error) {
                                console.log('compress-error:' + input);
                            } else {
                                console.log('compress-success:' + output);
                            }
                        });
                    } else {
                        console.log('compress-error');
                    }
                })
            }
        });
    },
};
dev.created();


