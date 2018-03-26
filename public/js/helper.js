//++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++ Helper.Js V1 Omid.h
//++++++++++++++++++++++++++++++++++++++++++++++


function getResponse( mode ){
    
//    switch(mode){
//        
//        case 'done':
//            $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
//            var success = $("div#absolute-message-box > p#message");
//            success.removeClass('hidden');
//            success.css('border','1px solid green')
//                .addClass("text-success bg-success alert")
//                .append(response['no-error']+'<br>' );         
//            $("div#absolute-message-box").fadeOut(1000);
//            location.reload(true); 
//        break;
//            
//        case'failed' :
//        
//        break;
//        
//    }
    
    
}

function prepareToSend(){
    
    $("div#absolute-message-box").css('display','none');
    $("div#absolute-message-box > p#loading-spinner")
        .css('border','1px solid orange')
        .removeClass('hidden');
    $("div#absolute-message-box > p#message").addClass('hidden');
    $("div#absolute-message-box > p#message").empty();
    $("div#absolute-message-box").fadeIn(500);
    
    return 0 ;
    
}