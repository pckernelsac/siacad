<?php $events = $this->db->get('events')->result_array();?>
<div class="content-w" > 
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
      <div class="conty"><br>
        <div class="container-fluid">
         <div class="layout-w">
          <div class="content-w">
            <div class="container-fluid"> 
              <div class="element-box">
                <h3 class="form-header"><?php echo get_phrase('calendar_events');?></h3><br>
                <div class="table-responsive">
                  <div id="calendar" class="col-centered"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="display-type"></div>
      </div>
<script>
  $(document).ready(function() 
  {   
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,basicWeek,basicDay'
        },
        defaultDate: $('#calendar').fullCalendar('today'),
        editable: false,
        defaultView: 'month',
        contentHeight: '100%',
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        select: function(start, end) {        
          $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
          $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
          $('#ModalAdd').modal('show');
        },
        eventAfterAllRender: function(view) {
                    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                        $('#calendar').fullCalendar('changeView', 'agendaDay');
                    }
                }, 
        eventDrop: function(event, delta, revertFunc) { // si changement de position
          edit(event);
        },
        eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
          edit(event);
        },
        events: [
        <?php foreach($events as $event): 
          $start = explode(" ", $event['start']);
          $end = explode(" ", $event['end']);
          if($start[1] == '00:00:00'){
            $start = $start[0];
          }else{
            $start = $event['start'];
          }
          if($end[1] == '00:00:00'){
            $end = $end[0];
          }else{
            $end = $event['end'];
          }
        ?>
          {
            id: '<?php echo $event['id']; ?>',
            title: '<?php echo $event['title']; ?>',
            start: '<?php echo $start; ?>',
            end: '<?php echo $end; ?>',
            color: '<?php echo $event['color']; ?>',
          },
        <?php endforeach; ?>
        ]
      });
    });
  </script>
  </div>
</div>