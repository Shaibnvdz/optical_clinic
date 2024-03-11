<?php 
include("config.php");
include("navbar.php");

    session_start();
    if(empty($_SESSION['user_id'])){
      echo "<script>alert('Please log in first.'); window.location.href='login.php'</script>";
    }
?>

<html>
<head>
    <style>
        .mContent{
          margin-top:130px;
          margin-left: 70px;
        }
        .col {
          float: left;
          margin: 25px;
          margin-left:145px;
        }
        .drag {
          width: 100px;
          height: 100px;
          position: relative;
          background-size: contain !important;
          background-repeat: no-repeat;
          float: left;
          border: solid 1px #CCC;
          border-radius:10px;
        }
        #droppable {
          border-radius:10px;
          width: 400px;
          height: 400px;
          border: 1px solid #CCC;
          margin-left: 30px;
          margin-top: -8px;
        }
        #droppable .drag {
          max-width: 250px;
          max-height:250px;
          background-size: 250px;
          border: none;
          resize: both;
          overflow: hidden;
        }
        #droppable .drag img {
          width: 100%;
          height: 100%;
          z-index: 0;
        }
        .preview{
          width: 400px;
          height:400px;
          border-radius:10px;
        }

        
    </style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        function show(vis){
          if(vis == 1){
            document.getElementById("contactLens").style.visibility = "visible";
            document.getElementById("frames").style.visibility = "hidden";
          }else{
            document.getElementById("contactLens").style.visibility = "hidden";
            document.getElementById("frames").style.visibility = "visible";
          }
        }
        
        var droppedCount = 0;
        // New function to remove the dragged element
        function removeDraggedElement(element) {
            $(element).parent().remove();
            droppedCount--;
        }
        $(document).ready(function() {
        var x = null;
        

        //Make element draggable
        $(".drag").draggable({
          helper: 'clone',
          cursor: 'move',
          tolerance: 'fit',
          stack: '.drag',
          revert: "invalid"
        });
        $("#droppable").droppable({
            drop: function(e, ui) {
                // Check the category and limit the number of dropped images accordingly
                var category = $(ui.draggable).attr('id');
                var maxDroppedCount = (category === 'drag7' || category === 'drag8' || category === 'drag9' || category === 'drag10' || category === 'drag11' || category === 'drag12') ? 2 : 1;

                if (droppedCount < maxDroppedCount) {
                    if ($(ui.draggable)[0].id != "") {
                        x = ui.helper.clone();
                        ui.helper.remove();
                        x.draggable({
                            containment: '#droppable',
                            tolerance: 'fit',
                            stack: '.drag'
                        });
                        x.append('<div style="position:absolute;margin-top:5px;cursor: pointer;" onclick="removeDraggedElement(this)">x</div>');
                        x.appendTo('#droppable');
                        droppedCount++; // Increment the dropped count
                    }
                }
            }
        });
    });
    window.onload = function() {
  // Check File API support
  if (window.File && window.FileList && window.FileReader) {
    var filesInput = document.getElementById("files");
    var output = document.getElementById("result");

    filesInput.addEventListener("change", function(event) {
      var files = event.target.files; // FileList object

      // Clear previous content
      output.innerHTML = "";

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        // Only pics
        if (!file.type.match('image'))
          continue;

        var picReader = new FileReader();
        picReader.addEventListener("load", function(event) {
          var picFile = event.target;
          var img = document.createElement("img");
          img.className = "preview";
          img.src = picFile.result;
          img.title = picFile.name;
          output.appendChild(img);
        });
        // Read the image
        picReader.readAsDataURL(file);
      }
    });
  } else {
    console.log("Your browser does not support File API");
  }
}
    </script>
</head>
<body>
    <div class="content-container" style="width:1100px;margin: 0 auto;padding:15px 0px;">
        <div class='mContent'>
          <div class="col" id="droppable">
            <form id='post-form' class='post-form' method='post'>
              <output id='result'></output>
              <input id='files' type='file'/>
              
            </form>
          </div>

          <div style="box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);border-radius:10px;width:445px;height:400px;margin-left:470px;margin-bottom:40px;">
            <div style="padding:20px;" id="frames">
                <h3 onclick="show(0)" style="color:#6b7e60;cursor: pointer;">Eyeglasses</h3><h3 onclick="show(1)" style="cursor: pointer;color:#7C9070;margin-top:-46px;margin-left:120px;">Contact lens</h3><br><br>
                <div style="display:grid; grid-template-columns: auto auto auto; gap:15px 50px; margin-top:-20px;">
                  <div id="drag1" class="drag" style="background-image:url(imagesfinal/tryon1.png); background-position:center;"></div>
                  <div id="drag2" class="drag" style="background-image:url(imagesfinal/tryon2.png); background-position:center;"></div>
                  <div id="drag3" class="drag" style="background-image:url(imagesfinal/tryon3.png); background-position:center;"></div>
                  <div id="drag4" class="drag" style="background-image:url(imagesfinal/tryon4.png); background-position:center;"></div>
                  <div id="drag5" class="drag" style="background-image:url(imagesfinal/tryon5.png); background-position:center;"></div>
                  <div id="drag6" class="drag" style="background-image:url(imagesfinal/tryon6.png); background-position:center;"></div>
                </div>
            </div>  

            <div style="margin-top:-340px;padding:20px;visibility:hidden;" id="contactLens">
                <h3 onclick="show(0)" style="color:#7C9070;cursor: pointer;">Eyeglasses</h3><h3 onclick="show(1)" style="cursor: pointer;color:#6b7e60;margin-top:-46px;margin-left:120px;">Contact lens</h3><br><br>
                <div style="display:grid; grid-template-columns: auto auto auto; gap:15px 50px; margin-top:-20px;">
                  <div id="drag7" class="drag" style="background-image:url(imagesfinal/contactlens1.png); background-position:center;"></div>
                  <div id="drag8" class="drag" style="background-image:url(imagesfinal/contactlens3.png); background-position:center;"></div>
                  <div id="drag9" class="drag" style="background-image:url(imagesfinal/contactlens4.png); background-position:center;"></div>
                  <div id="drag10" class="drag" style="background-image:url(imagesfinal/contactlens5.png); background-position:center;"></div>
                  <div id="drag11" class="drag" style="background-image:url(imagesfinal/contactlens6.png); background-position:center;"></div>
                  <div id="drag12" class="drag" style="background-image:url(imagesfinal/contactlens7.png); background-position:center;"></div>
                </div>
            </div> 
          </div>   
        </div>
    </div> 
</body>
</html>