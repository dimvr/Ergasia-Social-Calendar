<?php
date_default_timezone_set('Europe/Athens');

  class Hmerologio {

    public function __construct() {
      $this->ypesyndesmos = htmlentities($_SERVER['PHP_SELF']);
    }

    private $dayLabels = array('Δευτέρα', 
	                           'Τρίτη', 
							   'Τετάρτη', 
							   'Πέμπτη', 
							   'Παρασκευή', 
							   'Σάββατο', 
							   'Κυριακή');
							   
	private $monthLabels = array('Ιανουάριος', 
	                             'Φεβρουάριος', 
								 'Μάρτιος', 
								 'Απρίλιος', 
								 'Μάιος', 
								 'Ιούνιος', 
								 'Ιούλιος', 
								 'Αύγουστος', 
								 'Σεπτέμβριος', 
								 'Οκτώβριος', 
								 'Νοέμβριος', 
								 'Δεκέμβριος');
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $ypesyndesmos = null;

    public function newcalendar() {
      $year = null;
      $month = null;
      if (null == $year && isset($_GET['year'])) {
        $year = $_GET['year'];
      } elseif (null == $year) {
        $year = date("Y", time());
      }
      if (null == $month && isset($_GET['month'])) {
        $month = $_GET['month'];
      } elseif (null == $month) {
        $month = date("m", time());
      }
      $this->currentYear = $year;
      $this->currentMonth = $month;
      $this->daysInMonth = $this->_daysInMonth($month, $year);
      $content = '<div id="calendar">' . "\r\n" . 
	             '<div class="calendar_box">' . "\r\n" . $this->_createNavi() . "\r\n" . '</div>' . "\r\n" . 
				 '<div class="calendar_content">' . "\r\n" . 
				 '<ul class="calendar_label">' . "\r\n" . $this->_createLabels() . '</ul>' . "\r\n";
      $content .= '<div class="calendar_clear"></div>' . "\r\n";
      $content .= '<div id="ulcontent">' . "\r\n";
	  $content .= '<ul class="calendar_dates">' . "\r\n";
	  
      $weeksInMonth = $this->_weeksInMonth($month, $year);
      
      for ($i = 0; $i < $weeksInMonth; $i++) {
        
        for ($j = 1; $j <= 7; $j++) {
          $content .= $this->_showDay($i * 7 + $j);
        }
      }
      $content .= '</ul>' . "\r\n";
	  $content .= '</div>' . "\r\n";
      $content .= '<div class="calendar_clear"></div>' . "\r\n";
      $content .= '</div>' . "\r\n";
      $content .= '</div>' . "\r\n";
      return $content;
    }

    private function _showDay($cellNumber) {

		$mysqli = new mysqli('localhost', 'root', '', 'diforozi_mycalendar');
		$mysqli->set_charset('utf8');

		// ΑΡΧΙΚΟΠΟΙΗΣΗ ΟΡΙΣΜΕΝΩΝ ΜΕΤΑΒΛΗΤΩΝ ΠΟΥ ΧΡΗΣΙΜΟΠΟΙΟΥΜΕ ΣΕ LOOP
		
		$all_events      = '';
		$all_eventsa     = '';
		$add_event       = '';
		$delete_event    = '';
        $cdcount         = 0;		
		 
      if ($this->currentDay == 0) {
        $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
        if (intval($cellNumber) == intval($firstDayOfTheWeek)) {
          $this->currentDay = 1;
        }
      }
      if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {
        $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
        $cellContent = $this->currentDay;
	    $this_date = ''.$this->currentDay.'/'.$this->currentMonth.'/'.$this->currentYear.'';
		$this_insert_date = ''.$this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay.'';
		
		$dateint_now = date("Ymd");
		$dateint_now = (int)$dateint_now;
		$dateint_current = ( !empty($_GET['year']) ? $_GET['year'] : date("Y") ) . ( !empty($_GET['month']) ? $_GET['month'] : date("m") ) . ( $this->currentDay <10 ? '0'.$this->currentDay : $this->currentDay ); 
        $dateint_current = (int)$dateint_current;
		$dif =  $dateint_current - $dateint_now;
		
		if( $dif > 0 ){			
		$add_event = '<span title="Προσθήκη νέου γεγονότος από τον χρήστη '.$_SESSION['firstname'].' '.$_SESSION['lastname'].' για την ημερομηνία '.$this_date.'" data-toggle="modal" data-target="#exampleModal"><span onclick="eventdate(\''.$this_date.'\');prepareinsert(\''.$this_insert_date.'\');" class="glyphicon glyphicon-edit jsAction"></span></span>';
		}else{
        $add_event = '';			
		}

		// ΠΡΩΤΗ LOOP ΓΙΑ ΝΑ ΕΜΦΑΝΙΣΟΥΜΕ ΤΑ ΓΕΓΟΝΟΤΑ ΠΟΥ ΕΧΕΙ ΚΑΤΑΧΩΡΗΣΕΙ Ο ΣΥΝΔΕΔΕΜΕΝΟΣ ΧΡΗΣΤΗΣ
		
		$query  = "SELECT * FROM events WHERE events_date = '" . $this_insert_date . "' AND events_users_id = " . $_SESSION['systemuser'] . " ORDER BY events_time, events_id";
		$result = mysqli_query($mysqli,$query);
		$count  = mysqli_num_rows($result);
		
  if($count>0){
			
    for($i=0; $i<$count; $i++) {
			
        $row = mysqli_fetch_assoc($result);
		$inserted     = ''.substr($row['events_datetime_inserted'],8,2).'/'.substr($row['events_datetime_inserted'],5,2).'/'.substr($row['events_datetime_inserted'],0,4).' '.substr($row['events_datetime_inserted'],11,8).'';
        $events_date  = str_replace("-", "", $row['events_date']);
		$events_date  = (int)$events_date;	
		$dateint_nowa = date("Ymd");
		$dateint_nowa = (int)$dateint_nowa;			
		$difr =  $events_date - $dateint_nowa;				 
		$delete_event = '<div id="delcont'.$row['events_id'].'" style="display:none">&nbsp;<button onclick="DeleteEvent('.$row['events_id'].');" id="delevent'.$row['events_id'].'" type="button" class="btn-xs btn-danger pull-left">Διαγραφή</button><br><br></div>';		
		if( $difr > 0 ){	
		$all_events  .= '<div id="rowtitle' . $row['events_id'] . '" class="eventtitle" data-toggle="modal" data-target="#showfullevent">' . $delete_event . '<div class="jsAction" onclick="showfullevent(' . $row['events_id'] . ', \'delcont' . $row['events_id'] . '\', \'' . $row['events_title'] . '\', \'' . $row['events_description'] . '\', \'' . $this_date . '\', \'' . $row['events_time'] . '\', \'' . $row['events_users_name'] . '\', \'' . $inserted . '\');" title="Καταχωρήθηκε από τον χρήστη '.$row['events_users_name'].' στις '.$inserted.'"><span style="color:red">' . $row['events_time'] . '</span> ' . $row['events_title'] . '</div></div>';
        }else{
		$all_events  .= '<div id="rowtitle' . $row['events_id'] . '" class="eventtitle" data-toggle="modal" data-target="#showfulleventnoalert">' . $delete_event . '<div class="jsAction" onclick="showfulleventnoalert(\'delcont'.$row['events_id'].'\', \''.$row['events_title'].'\', \''.$row['events_description'].'\', \''.$this_date.'\', \''.$row['events_time'].'\', \''.$row['events_users_name'].'\', \''.$inserted.'\');" title="Καταχωρήθηκε από τον χρήστη '.$row['events_users_name'].' στις '.$inserted.'"><span style="color:red">' . $row['events_time'] . '</span> ' . $row['events_title'] . '</div></div>';
		}
        $all_eventsa .= '<div class="alleventtitle"><div style="position:relative"><span style="color:red">Γεγονός :</span> ' . $row['events_title'] . '<br><span style="color:red">Ημερομηνία :</span> ' . $this_date . '<br><span style="color:red">Ωρα :</span> ' . $row['events_time'] . '<br><span style="color:red">Περιγραφή :</span> '.$row['events_description'].'<br><span style="color:red">Ονοματεπώνυμο Χρήστη :</span> '.$row['events_users_name'].'<br><span style="color:red">Ημερομηνία Καταχώρησης :</span> '.$inserted.'<hr></div></div>'; 
		
    }
  }
				
		
  // ΔΕΥΤΕΡΗ (διπλή) LOOP ΓΙΑ ΝΑ ΕΜΦΑΝΙΣΟΥΜΕ ΤΑ ΓΕΓΟΝΟΤΑ ΠΟΥ ΕΧΕΙ ΚΑΤΑΧΩΡΗΣΕΙ ΑΛΛΟΣ ΧΡΗΣΤΗΣ ΣΤΟ ΔΙΚΟ ΤΟΥ ΗΜΕΡΟΛΟΓΙΟ 
  // ΚΑΙ ΤΑ ΕΧΕΙ ΚΟΙΝΟΠΟΙΗΣΕΙ (SHARE) ΣΤΟ ΗΜΕΡΟΛΟΓΙΟ ΤΟΥ ΣΥΝΔΕΔΕΜΕΝΟY ΧΡΗΣΤΗ 		

  $qsquery  = "SELECT events_alerts_events_id, events_alerts_users_id FROM events_alerts WHERE events_alerts_users_id = " . $_SESSION['systemuser'] . "";
  $qsresult = mysqli_query($mysqli,$qsquery);
  $qscount  = mysqli_num_rows($qsresult);
        
    if($qscount>0){ // Υπάρχουν κοινοποιήσεις προς τον συνδεδεμένο χρήστη !
		
	    for($qsi=0; $qsi<$qscount; $qsi++) { // Πρώτη Loop : Ζητάμε τα ID των γεγονότων που κοινοποιήθηκαν προς τον συνδεδεμένο χρήστη, από τον πίνακα events_alerts

            $qsrow = mysqli_fetch_assoc($qsresult);
 
		       $cdquery  = "SELECT * FROM events WHERE events_id = " . $qsrow['events_alerts_events_id'] . " AND events_date = '" . $this_insert_date . "'";
		       $cdresult = mysqli_query($mysqli,$cdquery);
		       $cdcount  = mysqli_num_rows($cdresult);         
	
	             if($cdcount>0){ // Υπάρχουν κοινοποιήσεις για τη συγκεκριμένη ημέρα !
				
                     for($cdi=0; $cdi<$cdcount; $cdi++) { // Δεύτερη Loop : Ζητάμε το γεγονός με βάση το ID του, το οποίο πήραμε από το προηγούμενο query και τη συγκεκριμένη ημέρα

                         // BOF ΔΕΔΟΜΕΝΑ ΑΠΟ ΗΜΕΡΟΛΟΓΙΑ ΑΛΛΩΝ ΧΡΗΣΤΩΝ ///////////////////////////////////////////////////////////////////
						 
                         $cdrow = mysqli_fetch_assoc($cdresult);
		                 $inserted     = ''.substr($cdrow['events_datetime_inserted'],8,2).'/'.substr($cdrow['events_datetime_inserted'],5,2).'/'.substr($cdrow['events_datetime_inserted'],0,4).' '.substr($cdrow['events_datetime_inserted'],11,8).'';
                         $events_date  = str_replace("-", "", $cdrow['events_date']);
		                 $events_date  = (int)$events_date;	
		                 $dateint_nowa = date("Ymd");
		                 $dateint_nowa = (int)$dateint_nowa;			
		                 $difr =  $events_date - $dateint_nowa;				 
						 $delete_event = '<div id="delcont'.$cdrow['events_id'].'" style="display:none">Κοινοποιημένο από άλλο χρήστη</div>';
						 if( $difr > 0 ){
						 $all_events  .= '<div id="rowtitle' . $cdrow['events_id'] . '" class="eventtitleotheruser" data-toggle="modal" data-target="#showfulleventnoalert">' . $delete_event . '<div class="jsAction" onclick="showfulleventnoalert(\'delcont'.$cdrow['events_id'].'\', \''.$cdrow['events_title'].'\', \''.$cdrow['events_description'].'\', \''.$this_date.'\', \''.$cdrow['events_time'].'\', \''.$cdrow['events_users_name'].'\', \''.$inserted.'\');" title="Το γεγονός αυτό είναι ΚΟΙΝΟΠΟΙΗΜΕΝΟ ! - Καταχωρήθηκε από τον χρήστη '.$cdrow['events_users_name'].' στις '.$inserted.'"><span style="color:red;font-style:italic">'.$cdrow['events_users_name'].'</span> : ' . $cdrow['events_title'] . '</div></div>';
 					     }else{
		                 $all_events  .= '<div id="rowtitle' . $cdrow['events_id'] . '" class="eventtitleotheruser" data-toggle="modal" data-target="#showfulleventnoalert">' . $delete_event . '<div class="jsAction" onclick="showfulleventnoalert(\'delcont'.$cdrow['events_id'].'\', \''.$cdrow['events_title'].'\', \''.$cdrow['events_description'].'\', \''.$this_date.'\', \''.$cdrow['events_time'].'\', \''.$cdrow['events_users_name'].'\', \''.$inserted.'\');" title="Το γεγονός αυτό είναι ΚΟΙΝΟΠΟΙΗΜΕΝΟ ! - Καταχωρήθηκε από τον χρήστη '.$cdrow['events_users_name'].' στις '.$inserted.'"><span style="color:red;font-style:italic">'.$cdrow['events_users_name'].'</span> : ' . $cdrow['events_title'] . '</div></div>';
		                 }
                         $all_eventsa .= '<div class="alleventtitle"><div style="position:relative"><span style="color:red">Γεγονός :</span> ' . $cdrow['events_title'] . '<br><span style="color:red">Ημερομηνία :</span> ' . $this_date . '<br><span style="color:red">Ωρα :</span> ' . $cdrow['events_time'] . '<br><span style="color:red">Περιγραφή :</span> '.$cdrow['events_description'].'<br><span style="color:red">Ονοματεπώνυμο Χρήστη :</span> '.$cdrow['events_users_name'].'<br><span style="color:red">Ημερομηνία Καταχώρησης :</span> '.$inserted.'<hr></div></div>'; 

                         // EOF ΔΕΔΟΜΕΝΑ ΑΠΟ ΗΜΕΡΟΛΟΓΙΑ ΑΛΛΩΝ ΧΡΗΣΤΩΝ ///////////////////////////////////////////////////////////////////

					 }
				 }			
	    }			
    }

		if($cdcount>0){ 
		$count = $count+$cdcount; 
		}else{
		$count = $count;	
		}
		
		if($count>6){ 
		$more_events     = '<div class="moreEvents"><span title="Περισσότερα γεγονότα για σήμερα..." class="glyphicon glyphicon-chevron-down"></span></div>';		
        $more_events_up  = '<div class="moreEventsUp"><span title="Περισσότερα γεγονότα για σήμερα..." class="glyphicon glyphicon-chevron-up"></span></div>';
		}else{
		$more_events     = '';
		$more_events_up  = '';
		}
		
		if($count>0){
		$show_all_events = '<div class="show-all-events" data-toggle="modal" data-target="#showallevents"><span title="Δείτε όλα τα γεγονότα για σήμερα..." onclick="showallevents(\'eventsofdaya' . $cellContent . '\', \''.$this_date.'\');" class="glyphicon glyphicon-th-list jsAction"></span></div>';			
		}else{
		$show_all_events = '';			
        }
		
		$this->currentDay++;
      } else {
        $this->currentDate = null;
        $cellContent = null;
		$add_event = '';
      }
      $today_day = date("d");
      $today_mon = date("m");
      $today_yea = date("Y");                                                                      
      $class_day = ($cellContent == $today_day && $this->currentMonth == $today_mon && $this->currentYear == $today_yea ? "calendar_today" : "calendar_days");
      if($cellContent === null){
	  $class_day =  'calendar_blank_box';	  
	  } 
      return '<li class="' . $class_day . '"><div class="daybox"><div class="addevent">' . $add_event . '</div><div style="display:none" id="eventsofdaya' . $cellContent . '">' .  ( !empty($all_eventsa) ? $all_eventsa : '' ) . '</div><div id="eventsofday' . $cellContent . '" class="showevent">' .  ( !empty($all_events) ? $all_events : '' ) . '</div><div class="numberOfTheDay">' . $cellContent . '</div>' .  ( !empty($more_events) ? $more_events : '' ) . '' .  ( !empty($more_events_up) ? $more_events_up : '' ) . '' .  ( !empty($show_all_events) ? $show_all_events : '' ) . '</div></li>' . "\r\n";
    }

    private function _createNavi() {
      $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth)+1;
      $nextYear  = $this->currentMonth == 12 ? intval($this->currentYear)+1 : $this->currentYear;
      $preMonth  = $this->currentMonth == 1 ? 12 : intval($this->currentMonth)-1;
      $preYear   = $this->currentMonth == 1 ? intval($this->currentYear)-1 : $this->currentYear;                                                                                                                                                                                 
      return '<div class="calendar_header">' . "\r\n" . '<span class="calendar_prev"><a class="month-navigation" href="' . $this->ypesyndesmos . '?page=newcalendar&amp;month=' . sprintf('%02d', $preMonth) . '&amp;year=' . $preYear . '">Προηγούμενος Μήνας</a></span>' . "\r\n" . '<span class="calendar_title">' . sprintf('%s ' . ( !empty($_GET['year']) ? $_GET['year'] : date("Y") ) . '', ( !empty($_GET['month']) ? $this->monthLabels[(int)strftime(''.$_GET['month'].'')-1] : $this->monthLabels[(int)strftime(''.date("m").'')-1] ) ) . '</span>' . "\r\n" . '<span class="calendar_next"><a class="month-navigation" href="' . $this->ypesyndesmos . '?page=newcalendar&amp;month=' . sprintf("%02d", $nextMonth) . '&amp;year=' . $nextYear . '">Επόμενος μήνας</a></span>' . "\r\n"  . '</div>';
    }

    private function _createLabels() {
      $content = '';
      foreach ($this->dayLabels as $index => $label) {
        $content .= '<li class="calendar_names">' . $label.'</li>' . "\r\n";
      }
      return $content;
    }

    private function _weeksInMonth($month = null, $year = null) {
      if (null == ($year)) {
        $year = date("Y", time());
      }
      if (null == ($month)) {
        $month = date("m", time());
      }
      $daysInMonths = $this->_daysInMonth($month, $year);
      $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
      $monthEndingDay = date('N',strtotime($year . '-' . $month . '-' . $daysInMonths));
      $monthStartDay = date('N',strtotime($year . '-' . $month . '-01'));
      if ($monthEndingDay < $monthStartDay) {
        $numOfweeks++;
      }
      return $numOfweeks;
    }

    private function _daysInMonth($month = null, $year = null) {
      if (null == ($year)) $year = date("Y",time());
      if (null == ($month)) $month = date("m",time());
      return date('t', strtotime($year . '-' . $month . '-01'));
    }
  }

?>