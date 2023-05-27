select all checkboxes inside specific element with class
========================================================
$('.content-wrapper input:checkbox')
add event
=========
$('.content-wrapper input:checkbox').click(function (event) {})

select all checkboxes inside DOM
================================
$("input[type='checkbox']")
add event
=========
$("input[type='checkbox']").click(function (event) {})

access attribute of selected element
====================================
$("input[type='checkbox']").click(function (event) {
$(this).attr("class")
})

find all input elements inside a specific element's closest element
===================================================================
$("#" + parentId).closest('div.checkboxes-wrapper').find("input")


GET ALL CHECKBOXES INSIDE A DIV
===============================
let selectedScopeElement= document.getElementsByClassName('checkboxes-wrapper '+ func_name)[0].querySelectorAll('input[type="checkbox"]');
