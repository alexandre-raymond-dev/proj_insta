$(document).ready(function() {
    $(".add-element").draggable({
      //  use a helper-clone that is append to "body" so is not "contained" by a pane
      helper: function() {
        return $(this).clone().removeClass("add-element").appendTo(".canvas").css({
          "zIndex": 5
        }).show();
      },
      cursor: "move",
      containment: "document"
    });
  
    $(".canvas, .canvas *").droppable({
      accept: ".add-element",
      drop: function(event, ui) { 
        if (!ui.draggable.hasClass("dropped"))
          $(this).append($(ui.draggable).clone().removeClass("ui-draggable").removeClass("dropped"));
      }
    }).sortable({
      placeholder: "sort-placer",
      cursor: "move",
      helper: function (evt, ui) {
        return $(ui).clone().appendTo(".canvas").show();
      }
    });
  });