<?php

include('../libraries/application_top.php');

/*
 * Σελίδα new_calendar.php
 * Εδώ αν δεν είμαι logged μου κάνει redirect στην σελιδα σύνδεση
 */
		
user_is_not_loged(); // Βλέπουμε αν ο χρήστης δεν έχει συνδεθεί. Αν αυτό ισχύει, ανακατευθύνουμε στη σελίδα login.php		
						 
include(HEADER_MENU); 
include(NEW_CALENDAR_CLASS);
?>

	<div class="main-content-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12"> 
					<h1>Το ημερoλόγιο των events μου.</h1>
					<div id="mynewcalendar">
					<?php
					      $calendar = new Hmerologio();
                          echo $calendar->newcalendar();
					?>
					</div>   
					
   <!-- ΕΜΦΑΝΙΖΕΙ ΤΗ ΦΟΡΜΑ ΚΑΤΑΧΩΡΗΣΗΣ ΝΕΟΥ ΓΕΓΟΝΟΤΟΣ -->
					
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="exampleModalLabel">Καταχώρηση νέου γεγονότος για την <span id="thisdate"></span><span id="thisuser"></span></h4>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-header"></span></span>
              <input placeholder="Τίτλος Γεγονότος" type="text" class="form-control" id="eventtitle">
			  </div>
            </div>
		    <div class="form-group">
                  <div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                <select class="form-control" id="eventtime">
                   <option value="08:00:00">8:00 πμ</option>
                   <option value="08:30:00">8:30 πμ</option>
				   <option value="09:00:00">9:00 πμ</option>
				   <option value="09:30:00">9:30 πμ</option>
				   <option value="10:00:00" selected>10:00 πμ</option>
				   <option value="10:30:00">10:30 πμ</option>
				   <option value="11:00:00">11:00 πμ</option>
				   <option value="11:30:00">11:30 πμ</option>
				   <option value="12:00:00">12:00 μμ</option>
				   <option value="12:30:00">12:30 μμ</option>
				   <option value="13:00:00">13:00 μμ</option>
				   <option value="13:30:00">13:30 μμ</option>
				   <option value="14:00:00">14:00 μμ</option>
				   <option value="14:30:00">14:30 μμ</option>
				   <option value="15:00:00">15:00 μμ</option>
				   <option value="15:30:00">15:30 μμ</option>
				   <option value="16:00:00">16:00 μμ</option>
				   <option value="16:30:00">16:30 μμ</option>
				   <option value="17:00:00">17:00 μμ</option>
				   <option value="17:30:00">17:30 μμ</option>
				   <option value="18:00:00">18:00 μμ</option>
				   <option value="18:30:00">18:30 μμ</option>
				   <option value="19:00:00">19:00 μμ</option>
				   <option value="19:30:00">19:30 μμ</option>
				   <option value="20:00:00">20:00 μμ</option>
				   <option value="20:30:00">20:30 μμ</option>
				   <option value="21:00:00">21:00 μμ</option>
				   <option value="21:30:00">21:30 μμ</option>
				   <option value="22:00:00">22:00 μμ</option>
				   <option value="22:30:00">22:30 μμ</option>
				   <option value="23:00:00">23:00 μμ</option>
				   <option value="23:30:00">23:30 μμ</option>
                </select>
				  </div>
            </div>
            <div class="form-group">
			  <div class="input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></span>
                 <textarea placeholder="Περιγραφή Γεγονότος" class="form-control" id="eventdescription"></textarea>
			   </div>	 
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button id="closemodal" type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
          <button id="insertevent" onclick="DBInsertEvent();" type="button" class="btn btn-primary">Καταχώρηση</button>
        </div>
      </div>
    </div>
  </div>
   
   <!-- ΕΜΦΑΝΙΖΕΙ ΤΟ ΓΕΓΟΝΟΣ ΚΑΙ ΤΙΣ ΛΕΙΤΟΥΡΓΙΕΣ : ΔΙΑΓΡΑΦΗ, ΚΟΙΝΟΠΟΙΗΣΗ, ΤΡΟΠΟΠΟΙΗΣΗ -->
  
    <div style="z-index:99999" class="modal fade" id="showfullevent" tabindex="-1" role="dialog" aria-labelledby="showfulleventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
		  <span id="thiseventdelete"></span>
          <h4 class="modal-title" id="showfulleventModalLabel"><span id="thiseventtitle"></span></h4>
        </div>
             <div class="modal-body">
                <span id="thiseventdescription"></span>
             </div>
        <div class="modal-footer">
		 <div class="btn-group pull-left"> 
		    <div class="btn-group">
		      <button data-toggle="collapse" data-target="#sharethisform" class="btn btn-success pull-left">Κοινοποίηση</button>
			</div>
			<div class="btn-group">
              <button onclick="EventEditPrepare();" data-toggle="collapse" data-target="#editeventform" class="btn btn-warning pull-left">Τροποποίηση</button>
            </div>
		 </div>
          <button id="closeeventdetails" type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>	
        </div>
		
				
<div id="sharethisform" class="calendarfunctions collapse modal-body">	
		<div class="modal-header">
          <h4 class="modal-title">Kοινοποίηση Γεγονότος</h4>
		</div> 
           <div class="line">&nbsp;</div>
		   <div>
           <form id="formshareevent">                                   
              <div class="form-group">
			     <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                   <input placeholder="Ονοματεπώνυμο Παραλήπτη" type="text" class="form-control" id="srname">
                 </div>
              </div>			  
              <div class="form-group">
			     <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                   <input placeholder="Email Παραλήπτη" type="text" class="form-control" id="srmail">
				 </div>
              </div>
           </form>	
           </div>
		<div class="modal-footer">
		   <span style="font-size:60%" class="pull-left"><b><u>Σημείωση</u> :</b> Ο παραλήπτης θα ειδοποιηθεί στο email του για αυτό το γεγονός,</span><br><span style="font-size:60%" class="pull-left">το οποίο θα προστεθεί και στο προσωπικό του ημερολόγιο, εάν διαθέτει.</span>
		   <button id="sharethiseventnow" onclick="DBEventShare();" type="button" class="btn btn-primary">Κοινοποίηση Γεγονότος</button>
		<div class="line">&nbsp;</div>
		<div style="text-align:left" class="pull-left" id="sharedataresponse"></div>
		</div>
</div>


<div id="editeventform" class="collapse modal-body">
		<div class="modal-header">
          <h4 class="modal-title">Τροποποίηση Γεγονότος</h4>
		</div>
           <div class="line">&nbsp;</div>
		   <div>
           <form id="formeditevent">                                   
              <div class="form-group">
			     <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-header"></span></span>
                   <input onkeyup="changeTitleWhileTyping()" placeholder="Τίτλος Γεγονότος" type="text" class="form-control" id="inputedittitle">
                 </div>
              </div>
              <div class="form-group">
			     <div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                <select class="form-control" id="selectedittime">
                   <option value="08:00:00">8:00 πμ</option>
                   <option value="08:30:00">8:30 πμ</option>
				   <option value="09:00:00">9:00 πμ</option>
				   <option value="09:30:00">9:30 πμ</option>
				   <option value="10:00:00" selected>10:00 πμ</option>
				   <option value="10:30:00">10:30 πμ</option>
				   <option value="11:00:00">11:00 πμ</option>
				   <option value="11:30:00">11:30 πμ</option>
				   <option value="12:00:00">12:00 μμ</option>
				   <option value="12:30:00">12:30 μμ</option>
				   <option value="13:00:00">13:00 μμ</option>
				   <option value="13:30:00">13:30 μμ</option>
				   <option value="14:00:00">14:00 μμ</option>
				   <option value="14:30:00">14:30 μμ</option>
				   <option value="15:00:00">15:00 μμ</option>
				   <option value="15:30:00">15:30 μμ</option>
				   <option value="16:00:00">16:00 μμ</option>
				   <option value="16:30:00">16:30 μμ</option>
				   <option value="17:00:00">17:00 μμ</option>
				   <option value="17:30:00">17:30 μμ</option>
				   <option value="18:00:00">18:00 μμ</option>
				   <option value="18:30:00">18:30 μμ</option>
				   <option value="19:00:00">19:00 μμ</option>
				   <option value="19:30:00">19:30 μμ</option>
				   <option value="20:00:00">20:00 μμ</option>
				   <option value="20:30:00">20:30 μμ</option>
				   <option value="21:00:00">21:00 μμ</option>
				   <option value="21:30:00">21:30 μμ</option>
				   <option value="22:00:00">22:00 μμ</option>
				   <option value="22:30:00">22:30 μμ</option>
				   <option value="23:00:00">23:00 μμ</option>
				   <option value="23:30:00">23:30 μμ</option>
                </select>
                 </div>
              </div>
              <div class="form-group">
			     <div class="input-group">
                   <span class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></span>
				   <textarea onkeyup="changeDescriptionWhileTyping()" placeholder="Περιγραφή Γεγονότος" class="form-control" id="inputeditdescription"></textarea>
				 </div>
              </div>
           </form>	
           </div>
		<div class="modal-footer">
		   <input type="hidden" value="" id="thisevenidedit">
		   <button id="editthiseventnow" onclick="DBEventEdit();" type="button" class="btn btn-primary">Τροποποίηση Γεγονότος</button>
		</div>
</div>			
      </div>
    </div>
  </div>
  

   <!-- ΕΜΦΑΝΙΖΕΙ ΤΟ ΓΕΓΟΝΟΣ ΧΩΡΙΣ ΛΕΙΤΟΥΡΓΙΕΣ ΚΟΙΝΟΠΟΙΗΣΗΣ ΚΑΙ ΤΡΟΠΟΠΟΙΗΣΗΣ ΟΤΑΝ ΕΧΕΙ ΠΑΡΕΛΘΕΙ ΚΑΠΟΙΑ ΗΜΕΡΟΜΗΝΙΑ -->
   
    <div class="modal fade" id="showfulleventnoalert" tabindex="-1" role="dialog" aria-labelledby="showfulleventnoalertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
		  <span style="font-size:60%;color:#FF0000;font-style:italic" id="thiseventdeletenoalert"></span>
          <h4 class="modal-title" id="showfulleventnoalertModalLabel"><span id="thiseventtitlenoalert"></span></h4>
        </div>
             <div class="modal-body">
                <span id="thiseventdescriptionnoalert"></span>
             </div>
        <div class="modal-footer">
          <button id="closeeventdetailsnoalert" type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
        </div>	
      </div>
    </div>
  </div> 
  
    <!-- ΕΜΦΑΝΙΖΕΙ ΟΛΑ ΤΑ ΓΕΓΟΝΟΤΑ ΚΑΠΟΙΑΣ ΗΜΕΡΟΜΗΝΙΑΣ ΧΩΡΙΣ ΕΠΙΠΛΕΟΝ ΛΕΙΤΟΥΡΓΙΕΣ -->
  
    <div class="modal fade" id="showallevents" tabindex="-1" role="dialog" aria-labelledby="showalleventsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="showalleventsModalLabel">Όλα τα γεγονότα της <span id="alleventstitledate"></span></h4>
        </div>
             <div class="modal-body">
                <div id="alleventsofday"></div>
             </div>
        <div class="modal-footer">
          <button id="closeeventdetails" type="button" class="btn btn-secondary" data-dismiss="modal">Κλείσιμο</button>
        </div>
      </div>
    </div>
  </div> 
  
<!-- 
     Το παρακάτω span χρησιμοποιείται ως σκανδάλη για να κάνει toogle την div eventinsertsuccess 
-->
<span style="display:none" id="fireeventok" data-toggle="modal" data-target="#eventinsertsuccess"></span>

<!-- 
     Το παρακάτω span χρησιμοποιείται για την προετοιμασία της ημερομηνίας εισαγωγής γεγονότος η οποία πρέπει να έχει συγκεκριμένη μορφή για να εισαχθεί
     στον πίνακα της βάσης δεδομένων.	 
-->
<span style="display:none" id="prepareinseretdate"></span>

<!-- 
     Το παρακάτω span χρησιμοποιείται για την προετοιμασία επεξεργασίας του τίτλου του γεγονότος	 
-->
<span style="display:none" id="thiseventonlytitle"></span>


<!-- ΧΡΗΣΙΜΟΠΟΙΟΥΜΕ ΕΝΑ MODAL ΠΑΡΑΘΥΡΟ ΓΙΑ ΝΑ ΕΝΗΜΕΡΩΝΟΥΜΕ ΤΟΝ ΧΡΗΣΤΗ ΓΙΑ ΤΑ ΑΠΟΤΕΛΕΣΜΑΤΑ ΔΙΑΦΟΡΩΝ ΕΝΕΡΓΕΙΩΝ -->
  
<div style="z-index:99999" class="modal fade bd-example-modal-lg" id="eventinsertsuccess" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="eventinsertsuccesscontent" class="modal-content"></div>
	      <div style="display:none" class="modal-footer">
          <span id="closeeventok" data-dismiss="modal"></span>
        </div>
  </div>
</div>  
				</div>
			</div>
		</div>
	</div>

<script>
  function eventdate(date) {  
    document.getElementById('thisdate').innerHTML =	''+date+'';
    document.getElementById('thisuser').innerHTML = '<?php echo (user_is_loged() ? '<br>'.$_SESSION['firstname'].' '.$_SESSION['lastname'].' ('.$_SESSION['email'].')' : ''); ?>';
  }

  function prepareinsert(insertdate) {  
    document.getElementById('prepareinseretdate').innerHTML = ''+insertdate+''; 
  }

  function DeleteEvent(deleventid) {
        var EventDeleteID = deleventid;	
        $.ajax({
            url: "ajax_delete_calendar_event.php",
            data: {dlEventsID:EventDeleteID},
            type: "POST",
			beforeSend: function() {
			   document.getElementById('eventinsertsuccesscontent').innerHTML = '<br><br>&nbsp;&nbsp;&nbsp;Γίνεται διαγραφή.... περιμένετε<br><br>';
			   document.getElementById('fireeventok').click();
            },
            success: function(data) {
               document.getElementById('eventinsertsuccesscontent').innerHTML = '<br><br>&nbsp;&nbsp;&nbsp;Εντάξει !!!<br><br>&nbsp;&nbsp;&nbsp;Η διαγραφή του γεγονότος ολοκληρώθηκε !<br><br>';
			   setTimeout(function(){ 
                  document.getElementById('closeeventok').click();	
               }, 3000);  
               setTimeout(function(){ 
                  document.getElementById('closeeventdetails').click();
                  document.getElementById('closeeventdetailsnoalert').click();
	           $('#rowtitle'+EventDeleteID).hide();
               }, 3150);
            }
        });	  
  }

  function DBInsertEvent() {   
    var forthisdate       = document.getElementById('thisdate').innerHTML;
    var insertUserID      = '<?php echo $_SESSION['systemuser']; ?>';
    var insertUserName    = '<?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>'; 
    var insertDate        = document.getElementById('prepareinseretdate').innerHTML;
    var insertTime        = document.getElementById('eventtime').options[document.getElementById('eventtime').selectedIndex].value;
    var insertTitle       = document.getElementById('eventtitle').value;
    var insertDescription = document.getElementById('eventdescription').value;
    document.getElementById('insertevent').innerHTML = '<img style=\"vertical-align: middle\" border=\"0\" src=\"../images/ajax-loader-small.gif\" width=\"16\">';
        $.ajax({
            url: "ajax_insert_calendar_event.php",
            data: {ajaxUserID:insertUserID, ajaxUserName:insertUserName, ajaxDate:insertDate, ajaxTime:insertTime, ajaxTitle:insertTitle, ajaxDescription:insertDescription},
            type: "POST",
			beforeSend: function() {
			document.getElementById('eventinsertsuccesscontent').innerHTML = '<br><br>&nbsp;&nbsp;&nbsp;Γίνεται εισαγωγή γεγονότος.... περιμένετε<br><br>';
			document.getElementById('fireeventok').click();
            },
            success: function(data) {
               setTimeout(function(){
                  document.getElementById('closemodal').click();
                  document.getElementById('insertevent').innerHTML = 'Καταχώρηση';				
			   }, 2000); 
               setTimeout(function(){  
                  document.getElementById('eventinsertsuccesscontent').innerHTML = '<br>&nbsp;&nbsp;<b>Η καταχώρηση γεγονότος για την ημερομηνία '+forthisdate+' ήταν επιτυχής !</b><br><br>&nbsp;&nbsp;<b>ID Χρήστη :</b> '+insertUserID+'<br><br>&nbsp;&nbsp;<b>Όνομα Χρήστη :</b> '+insertUserName+'<br><br>&nbsp;&nbsp;<b>Ημερομηνία Γεγονότος :</b> '+insertDate+'<br><br>&nbsp;&nbsp;<b>Ώρα Γεγονότος :</b> '+insertTime+'<br><br>&nbsp;&nbsp;<b>Τίτλος Γεγονότος :</b> '+insertTitle+'<br><br>&nbsp;&nbsp;<b>Περιγραφή Γεγονότος :</b> '+insertDescription+'<br><br>'; 
               }, 2150);
               setTimeout(function(){
                  document.getElementById('fireeventok').click();
               }, 6000);
               setTimeout(function(){ 
                  document.getElementById('closeeventok').click();
                  document.getElementById('eventtitle').value = '';
                  document.getElementById('eventdescription').value = '';	
               }, 8000);
            }
        });
  }

  function DBEventEdit () {	  
    var EditEventID           = document.getElementById('thisevenidedit').value;   
    var EditInsertTitle       = document.getElementById('inputedittitle').value;
    var EditInsertTime        = document.getElementById('selectedittime').options[document.getElementById('selectedittime').selectedIndex].value;
    var EditInsertDescription = document.getElementById('inputeditdescription').value;	
    document.getElementById('editthiseventnow').innerHTML = '<img style=\"vertical-align: middle\" border=\"0\" src=\"../images/ajax-loader-small.gif\" width=\"16\">&nbsp;'+document.getElementById('editthiseventnow').innerHTML;
        $.ajax({
            url: "ajax_edit_calendar_event.php",
            data: {ajaxEventID:EditEventID, ajaxEditTitle:EditInsertTitle, ajaxEditTime:EditInsertTime, ajaxEditDescription:EditInsertDescription},
            type: "POST",
            success: function(data) {
               setTimeout(function(){
                  document.getElementById('editthiseventnow').innerHTML = 'Τροποποίηση Γεγονότος';
                  document.getElementById('eventinsertsuccesscontent').innerHTML = '<br>&nbsp;&nbsp;<b>Η τροποποίηση του γεγονότος ήταν επιτυχής !<br><br>';				  
			   }, 2000); 
               setTimeout(function(){
                  document.getElementById('fireeventok').click();
               }, 2100);
               setTimeout(function(){ 
                  document.getElementById('closeeventok').click();	
               }, 5600);			   
            }
        });  
  }

  function DBEventShare() {  
    var SREventID          = document.getElementById('thisevenidedit').value;
    var SRReceiverName     = document.getElementById('srname').value;
    var SRReveiverEmail    = document.getElementById('srmail').value;  
    var SREventTitle       = document.getElementById('injectedtitle').innerHTML;
    var SREventDescription = document.getElementById('thiseventdescription').innerHTML;
    var SREventDateTime    = document.getElementById('injecteddatetime').innerHTML;
        $.ajax({
            url: "ajax_share_calendar_event.php",
            data: {SRajaxEventID:SREventID, 
			       SRajaxReceiverName:SRReceiverName, 
				   SRajaxReveiverEmail:SRReveiverEmail,
				   SRajaxEventTitle:SREventTitle,
				   SRajaxEventDescription:SREventDescription,
				   SRajaxEventDateTime:SREventDateTime
				  },
            type: "POST",
			beforeSend: function() {
               document.getElementById('sharethiseventnow').innerHTML = '<img style=\"vertical-align: middle\" border=\"0\" src=\"../images/ajax-loader-small.gif\" width=\"16\">&nbsp;'+document.getElementById('sharethiseventnow').innerHTML;
            },			
            success: function(data) {
			   document.getElementById('sharethiseventnow').innerHTML = 'Κοινοποίηση Γεγονότος'; 
               $("#sharedataresponse").html(data);
            }
        });  
  }

  function changeTitleWhileTyping() {  
    document.getElementById('injectedtitle').innerHTML = document.getElementById('inputedittitle').value;		
  }

  function changeDescriptionWhileTyping() { 
    document.getElementById('thiseventdescription').innerHTML = document.getElementById('inputeditdescription').value;		
  }

  function EventEditPrepare() {	  
    document.getElementById('inputedittitle').value =	document.getElementById('thiseventonlytitle').innerHTML;
    document.getElementById('inputeditdescription').value =	document.getElementById('thiseventdescription').innerHTML;
  }
  
  function showfullevent(eventid, container, title, description, date, time, username, inserted) { 
    document.getElementById('srname').value = '';
    document.getElementById('srmail').value = '';
    document.getElementById('sharedataresponse').innerHTML = '';
    document.getElementById('thisevenidedit').value = eventid;
    document.getElementById('thiseventonlytitle').innerHTML = ''+title+'';
    document.getElementById('thiseventdelete').innerHTML = document.getElementById(container).innerHTML;
    document.getElementById('thiseventtitle').innerHTML =	'<span id="injectedtitle">'+title+'</span><br><span id="injecteddatetime" style="font-size:11px">Προγραμματισμένο γεγονός για '+date+' στις '+time+'</span><br><span  id="injecteduserwhen" style="font-size:11px">Καταχωρήθηκε από τον χρήστη '+username+' στις '+inserted+'</span>';
    document.getElementById('thiseventdescription').innerHTML =	''+description+'';
    EventEditPrepare();
  }

  function showfulleventnoalert(container, title, description, date, time, username, inserted) { 
    document.getElementById('thiseventdeletenoalert').innerHTML = document.getElementById(container).innerHTML;	
    document.getElementById('thiseventtitlenoalert').innerHTML = ''+title+'<br><span style="font-size:11px">Προγραμματισμένο γεγονός για '+date+' στις '+time+'</span><br><span style="font-size:11px">Καταχωρήθηκε από τον χρήστη '+username+' στις '+inserted+'</span>';
    document.getElementById('thiseventdescriptionnoalert').innerHTML = ''+description+'';
  }
  
  function showallevents(divid,thisdate) {  
    document.getElementById('alleventstitledate').innerHTML = ''+thisdate+'';	
    document.getElementById('alleventsofday').innerHTML = document.getElementById(divid).innerHTML;
  }

  $('#exampleModal').on('hidden.bs.modal', function (e) {
	// Bootstrap : Λειτουργία που μπορούμε να εκτελέσουμε όταν γίνει απόκρυψη ενός modal παραθύρου του Bootstrap.  
  })

  $(document).ready(function() {
	// niceScroll : Πρόσθετο του jQuery που εμφανίζει αυτόματα ένα μικρό διακριτικό οριζόντιο ή κάθετο scroll bar εάν χρειάζεται, σε όποιο DOM αντικείμενο
	// υπάρχει overflow (το κείμενο δε χωράει στις διαστάσεις του αντικειμένου [table, div κλπ])
    $(".showevent").niceScroll({cursorcolor:"#B0B0B0"});
  });
</script>
		

<?php
include(FOOTER);
include(APPLICATION_BOTTOM_SCRIPT);
?>