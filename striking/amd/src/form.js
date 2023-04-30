/**
 * @module qtype_striking/form
 */

define(['jquery'], function($) {

    "use strict";
    var StrikForm = {
        init: function() {
            var CountAnsw =0

            $(document).on('change','#id_sentence', newStrik)
            $(document).on('click','.striking', function (){
                var s=""+($(this).css('textDecoration'))
                if( s.indexOf('line-through')==-1 ){
                    $(this).css('textDecoration', 'line-through')
                    CountAnsw+=1
                    var percent = fract()
                    var word = $(this).text()
                    var anws = $("input[id^='id_answer_']")
                    for(let i=0;i<anws.length;i++){
                        var t = anws[i]
                        if(t.value==""){
                            //anws[i].disabled=false
                            anws[i].value = word+"+"+$(this).attr('id')
                            //anws[i].disabled=true
                            break
                        }
                        else if(i==(anws.length-1)){
                                $("#id_addanswers").click()
                            }
                    }
                    mark()

                }
                else {
                    CountAnsw-=1
                    var percent=fract()
                    $(this).css('textDecoration', 'none')
                    var word = $(this).text()+"+"+$(this).attr('id')
                    var anws = $("input[id^='id_answer_']")
                    for(let i=0;i<anws.length;i++){
                        var t = anws[i]
                        if(t.value==word){
                            //anws[i].disabled=false
                            anws[i].value = ""
                            //anws[i].disabled=true
                            break
                        }

                    }
                    mark()
                }})

            $(document).ready(function() {
                $("#id_generalheader").append("<div id='fornew' style='margin: 20px;font-size:larger;'></div>")

                if($("#id_sentence").val()!=""){
                    fillSpan()
                    var anws = $("input[id^='id_answer_']")
                    $.each(anws,function (){

                        if($(this).val()!=""){
                            CountAnsw+=1
                            var an = $(this).val().split("+")[1]
                            $('span[id="' + an + '"]').css('textDecoration','line-through')
                        }
                    })
                }
            })

            function newStrik(){
                CountAnsw=0
                var anws = $("input[id^='id_answer_']")
                for(let i=0;i<anws.length;i++){
                    var t = anws[i]
                    if(t.value!==""){
                        anws[i].value = ""
                    }
                }
                mark()
                fillSpan()
            }

            function fillSpan(){
                var arr = $("#id_sentence").val().split(" ")
                var str = ""
                $.each(arr, function (index,value){
                    str+="<span class='striking' id='"+index+"'>"+value+"</span> "
                })
                $("#fornew").html(str)
            }

            function fract(){
                var per=parseFloat((1/CountAnsw).toFixed(7))
                if(per==0) return "0.0"
                else if(per==1) return "1.0"
                else return per
            }

            function mark(){
                var mar = fract()
                var answ = $("input[id^='id_answer_']")
                for(let i=0;i<answ.length;i++){
                    var t = answ[i]
                    if(t.value==""){
                        var sel = $("select[id='id_fraction_"+i+"'] option[value='"+"0.0"+"']")
                        sel.prop('selected', true);
                    }
                    else{
                        var sel = $("select[id='id_fraction_"+i+"'] option[value='"+mar+"']")
                        sel.prop('selected', true);
                    }
                }
            }
            },
    };



    return {
        init: StrikForm.init
    };
});
