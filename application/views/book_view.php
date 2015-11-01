<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/dropdown.js"></script>

<!--<span id="spantabs"><a href="#" onClick="setSom2();">Закладка 1</a></span>
<span id="test_value">Тут</></span>
<button id="but1">Ajax</button>-->

<script type="text/javascript">
/*  var selGroup = document.getElementById("selGroup");
  $(document).ready(function(){
    selGroup.click(function() {
      alert("click on SEL");
    })
  });
*/
  var groupAj;
  function selChange() {
    if(selGroup.options[selGroup.selectedIndex].value != "") {
      groupAj = "group="+selGroup.options[selGroup.selectedIndex].value;
    }
    else {
      groupAj = "group=*";
    }
    SendAj();
  };

  function SendAj() {
    //alert('start');
    var req;
    if (window.XMLHttpRequest) req = new XMLHttpRequest();
    else if (window.ActiveXObject) {
      try {
        req = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (e) {
      }
      try {
        req = new ActiveXObject('Microsoft.XMLHTTP');
      } catch (e) {
      }
    }
    if (req) {
      req.onreadystatechange = function () {
        if (req.readyState == 4 && req.status == 200) {
          //alert(req.responseText);
          document.getElementById("mainContent").innerHTML = req.responseText;
        }
      };
      req.open("POST", 'http://WofT/book/dat', true);
      req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      req.send(groupAj);
    }
    else alert("Браузер не поддерживает AJAX");
  }

</script>

  //построение всех выборок
  <select id="selGroup" onChange="selChange.call()">
  <option value="">Выбрать группу</option>;
      <?php
      for($i=0; $i<count($data["groups"]); $i++) {
      echo '<option value='.$data["groups"][$i]["group_name"].'>'.$data["groups"][$i]["group_name"].'</option>';
      };
      ?>
  </select>


<div id="mainContent"></div>
<!--<table class="table">
  <thead>
    <tr>
      <th>Имя</th>
      <th>Фамилия</th>
    </tr>
  </thead>
  <tbody>
    <? ?>

      //echo var_dump($data["dat"]);
      //echo "rows:  ".$data["dat"]["rows"];
      //echo "  fields:  ".$data["dat"]["fields"];
      for($i=0; $i<$data["dat"]["rows"]; $i++) {
        echo "<tr>";
        for($j=0; $j<$data["dat"]["fields"]; $j++) {
          echo "<td>".$data["dat"][$i][$j]."</td>";
        }
        echo "/<tr>";
      }
    ?>
    </tbody>
</table>



<!--
<script>
  //  $(document).ready(function () {
  //    $('.dropdown-toggle').mouseover(function() {
  //  })
  $("#sl").bind('click', function(){
    var thisVar = $(this).val();
    if(!thisVar) return false;
    alert(thisVar);
  });

</script>
-->

<!--<div id="dat"> </div>



<div class="btn-group">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    Выбор группы
    <span class="caret"></span>
    <!--    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Выпадающий список
          <i class="caret"></i>
          <br>

  </a>
  <ul class="dropdown-menu" id="sel">
    <li><a href="#" onclick="">Группа А</a></li>
    <li><a href="#">Группа Б</a></li>
  </ul>
</div>

<script>
  //  $(document).ready(function () {
  //    $('.dropdown-toggle').mouseover(function() {
  //  })
  $('.dropdown-toggle').bind('', function(){
    var thisVar = $(this).val();
    if(!thisVar) return false;
    alert(thisVar);
  });

</script>
-->