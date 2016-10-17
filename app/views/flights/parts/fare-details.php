<script type="text/mustache" id="route-item-details-template">
  {{#outbound}}
    
    <div class="details_name"><span class="outbound">OUTBOUND DETAILS:</span><span  class="total_duration"><strong>Total Duration:</strong> {{duration}}</span></div>

    {{#trips}}
      
      {{#layover}}
        <div class="layover">
            <span class="layover_place">Layover in {{place}}</span><span class="layover_time">{{time}}</span>
        </div>
      {{/layover}}
      
      <div class="departs_arrives">
        <div class="airline"><img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"><p>{{designator_code}}</p></div>
        <div class="from_in"><span class="timedate">{{departure_time}}</span><br /><span class="depart">Departs from {{departure_name}} ({{departure_code}})</span></div>
        <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
        <div class="from_in"><span class="timedate">{{arrival_time}}</span><br /><span class="depart">Arrives at {{arrival_name}} ({{arrival_code}})</span></div>
        <div class="total_duration"><span>{{duration}}</span></div>
        <div class="clear"></div>
      </div>

    {{/trips}}
  {{/outbound}}

  {{#inbound}}
    <div class="details_name inbound_name"><span class="outbound">INBOUND DETAILS:</span><span  class="total_duration"><strong>Total Duration</strong> {{duration}}</span></div>
    {{#trips}}
      {{#layover}}
        <div class="layover">
            <span class="layover_place">Layover in {{place}}</span><span class="layover_time">{{time}}</span>
        </div>
      {{/layover}}
      
      <div class="departs_arrives">
        <div class="airline"><img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"><p>{{designator_code}}</p></div>
        <div class="from_in"><span class="timedate">{{departure_time}}</span><br /><span class="depart">Departs from {{departure_name}} ({{departure_code}})</span></div>
        <div class="plane_block"><img class="plane" src="/img/icons/plane.svg" /></div>
        <div class="from_in"><span class="timedate">{{arrival_time}}</span><br /><span class="depart">Arrives at {{arrival_name}} ({{arrival_code}})</span></div>
        <div class="total_duration"><span>{{duration}}</span></div>
        <div class="clear"></div>
      </div>
    {{/trips}}
  {{/inbound}}

  {{#book_link}}
      <div class="book_now"><a href="{{book_link}}" target="_blank"><input type="button" class="btn btn-primary btn-lg" value="BOOK NOW"></a></div>
  {{/book_link}}

</script>