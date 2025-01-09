// script/modal.js


$(document).ready(function() {
  $("[id=glass_container]"). on('click', function(e) {
    e.preventDefault();

    var $link = $(e.currentTarget);
    
    var middle = e.currentTarget.querySelector('.glass_middle');
    var header = e.currentTarget.querySelector('.glass_header');
   
    $.ajax({
      method: 'POST',
      url: $link.attr('href')
    }).done(function(data) {
	if(! document.URL.includes("barView"))
	{
           $(middle).css('height', middle.clientHeight + 4);
	}
        var shots = Number($(header).html());
        shots ++;
        console.log(shots);
        $(header).html(shots);
    })

  });

  
  if(document.URL.includes("newTeam") ||
      document.URL.includes("chart"))
//      document.URL.includes("barView"))
  {
    console.log("not main page. Do not reload");
    return;
  }

  setInterval(function(){
    $.ajax({
      url: "/update/teams",
      method: "POST",
      dataType: "json",
      success: updateTeams
    });
  }, 2000);
});

function updateTeams(data)
{
  // console.log(data);
  
  var recCount = Object.keys(data).length;
  var dispTeams = $('[id^="scoreHeight_team_"]');
  var actCount = dispTeams.length;

  console.log("asasas: " + recCount + " / " + actCount);

  if(! (document.URL.includes("newTeam") ||
      document.URL.includes("chart") ||
      document.URL.includes("barView")) &&
      recCount > 10)
  {
     recCount = 10;
  }

  if(recCount != actCount)
  {
    console.log("anzahl geandert? "+ recCount + " / " + actCount)
    location.reload();
    return;
  }

  if(! document.URL.includes("barView"))
  {
    for( let i = 0; i < recCount; i++)
    {
      var team = data[i];
      var id = Number($(dispTeams[i]).attr('id').substring(17));
      if(Number(team[0]) != id)
      {
        console.log("position geandert: " + team[0] + " / " + id);
        location.reload();
	      return;
      }
    }
  }
  for(let i = 0; 1 < recCount; i++)
  {
    var team = data[i];
    renderTeamHeight(team[0], team[1]);
  }
 
  //scoreHeight_team_{{ team.id }}
}

function renderTeamHeight(team, cnt)
{
  var item = $("#scoreHeight_team_" + team);
  if(! document.URL.includes("barView"))
  {
  	item.css("height", Number(cnt)* 4);
	if(Number(cnt) > 190)
	 {
	    $("#score_team_" + team).hide();
	    var inner = item.children().first();
            inner.html(Number(cnt));
 	    inner.show();       
	 }
  }
  $("#score_team_" + team).html(cnt);
}
