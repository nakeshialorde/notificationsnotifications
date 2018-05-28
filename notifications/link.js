<script>
$(document).ready(function(){
// updating the view with notifications using ajax
function load_unseen_notification(view = '')
{
 $.ajax({
  url:"fetch.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data)

  {
   $('.dropdown-menu').html(data.notification);
   if(data.unseen_notification > 0)
   {
    $('.count').html(data.unseen_notification);
   }
  }
 });
}

load_unseen_notification();

// submit form and get new records
$('#notifications').on('submit', function(event){
 event.preventDefault();
 if($('#email').val() != '' && $('#subject').val() != '' && $('#message').val() != '') //Form data to send to database
 {
  var form_data = $(this).serialize();
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:form_data,
   success:function(data)
   {
    $('#notifications')[0].reset();
    load_unseen_notification();
   }
  });
 }

 else
 {
  alert("All Fields are Required");
 }
});

// load new notifications
$(document).on('click', '.dropdown-toggle', function(){
 $('.count').html('');
 load_unseen_notification('yes');
});

setInterval(function(){
 load_unseen_notification();;
}, 5000);
});

</script>
