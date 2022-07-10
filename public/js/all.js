// script/modal.js


$(document).ready(function() {
  $("[id=glass_container]"). on('dblclick', function(e) {
    e.preventDefault();

    var $link = $(e.currentTarget);
    
    var middle = e.currentTarget.querySelector('.glass_middle');
    var header = e.currentTarget.querySelector('.glass_header');
   
    $.ajax({
      method: 'POST',
      url: $link.attr('href')
    }).done(function(data) {
        $(middle).css('height', middle.clientHeight + 4);
        var shots = Number($(header).html());
        shots ++;
        console.log(shots);
        $(header).html(shots);
    })

  });
});



function openConfig(){
    $( "#configDialog" ).dialog({
        autoOpen: true,
        draggable : false,
        height: 400,
        width: 600,
        buttons: [
            {
                text: "Abbruch",
                icon: "ui-icon-closethick",
                click: function() {
                  $( this ).dialog( "close" );
                }
           
                // Uncommenting the following line would hide the text,
                // resulting in the label being used as a tooltip
                //showText: false
            },
            {
              text: "Ok",
              icon: "ui-icon-check",
              click: function() {
                $( this ).dialog( "close" );
              }
         
              // Uncommenting the following line would hide the text,
              // resulting in the label being used as a tooltip
              //showText: false
            }
          ]
    });
}

openConfig()
