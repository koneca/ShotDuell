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
        $(middle).css('height', middle.clientHeight + 6);
        var shots = Number($(header).html());
        shots ++;
        console.log(shots);
        $(header).html(shots);
    })

  });

  
  if(document.URL.includes("newTeam") ||
      document.URL.includes("chart"))
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
  var actCount = $('[id^="scoreHeight_team_"]').length;
  
  if(recCount != actCount)
  {
    location.reload();
  }

  for( let team in data)
  {
    if(data.hasOwnProperty(team))
    {
      renderTeamHeight(team, data[team]);
    }
  }
  //scoreHeight_team_{{ team.id }}
}

function renderTeamHeight(team, cnt)
{
  var item = $("#scoreHeight_team_" + team).css("height", Number(cnt)* 6);
  if(0 == item.length)
  {
    console.log("New team found: scoreHeight_team_" + team + " reloading!");
    location.reload();
    return;
  }
  $("#score_team_" + team).html(cnt);
}