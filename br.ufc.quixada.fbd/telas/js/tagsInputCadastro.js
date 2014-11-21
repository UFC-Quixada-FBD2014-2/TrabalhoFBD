
var elt = $('#tags');
elt.tagsinput({
  tagClass: function() {
	var item = Math.floor((Math.random() * 100) + 1);  
    if(item <=20) return 'label label-primary';
    else if(item>20 && item<=40) return 'label label-danger';
    else if(item>40 && item<=60) return 'label label-success';
    else if(item>60 && item<=80) return 'label label-default';
    else if(item>80 && item<=100) return 'label label-warning';
    else return 'label-important';
  },
  displayKey: 'name',
  valueKey: 'name'
});