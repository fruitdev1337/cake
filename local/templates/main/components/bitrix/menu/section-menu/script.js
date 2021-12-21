$(document).ready(function () {

     $(document).on('click', 'ul#vertical-multilevel-menu i', function (e) {
         // e.preventDefault();
            $(this).parent().toggleClass('item-selected');
     });

});



var jsvhover = function()
{
	var menuDiv = document.getElementById("vertical-multilevel-menu");
	if (!menuDiv)
		return;

  var nodes = menuDiv.getElementsByTagName("li");
  for (var i=0; i<nodes.length; i++) 
  {
    nodes[i].onmouseover = function()
    {
      this.className += " jsvhover";
    }
    
    nodes[i].onmouseout = function()
    {
      this.className = this.className.replace(new RegExp(" jsvhover\\b"), "");
    }
  }
};

if (window.attachEvent) 
	window.attachEvent("onload", jsvhover);


//
// $(document).ready(function () {
//     if ($('li.item-selected').find('ul li.sub-item-selected')) {
//         $('li.item-selected').addClass('selected-in');
//     }
// });
