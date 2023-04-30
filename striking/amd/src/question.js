/**
 * @module qtype_striking/question
 */

define(['jquery'], function($) {

    "use strict";

    var StrikQue = {

        init: function() {

            $(document).ready(function (){

                var stQus = $('div.que.striking')
                $.each(stQus, function (){
                    var inp = $(this).find("input[id$='_answer']")[0].value
                    if(inp!=""){
                        var words = inp.split(',')
                        var sent = $(this).find(".qsentence")[0]
                        for(let i =0;i< words.length;i++){
                            if(words[i]!=""){
                                var wordID = words[i].split('+')[1]
                                $(sent).find("span[id='"+wordID+"']").css('textDecoration', 'line-through')
                            }

                        }
                    }
                })

                if ((document.location.href).indexOf('review')==-1){
                    $(document).on('click','.striking_elem', function (){
                        var s=""+($(this).css('textDecoration'))
                        var word = $(this).text()+"+"+$(this).attr('id')
                        if( s.indexOf('line-through')==-1 ){
                            $(this).css('textDecoration', 'line-through')
                            if($("input[id$='_answer']")[0].value!=""){
                                $("input[id$='_answer']")[0].value += ","+word
                            }
                            else{
                                $("input[id$='_answer']")[0].value += word
                            }

                        }
                        else {
                            $(this).css('textDecoration', 'none')
                            $("input[id$='_answer']")[0].value = (($("input[id$='_answer']")[0].value).replace(word,"")).replace(",,",",")
                            if(($("input[id$='_answer']")[0].value).slice(0,1) == ","){
                                $("input[id$='_answer']")[0].value = $("input[id$='_answer']")[0].value.slice(1)
                            }
                            else if(($("input[id$='_answer']")[0].value).slice(-1) == ","){
                                $("input[id$='_answer']")[0].value = $("input[id$='_answer']")[0].value.slice(0,-1)
                            }
                        }})
                }

            })
        },
    };
    return {
        init: StrikQue.init
    };
});