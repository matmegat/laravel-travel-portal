<div class="modal fade" id="fare-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Hotels Details</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script type="text/mustache" id="route-item-details-template">
  <div dir="ltr" class="clearfix">
    <table class="wego-flight-detail-table">
      <tbody>
        {{#outbound}}
        <tr>
          <td colspan="2" class="wego-flight-date">
            <strong>Outbound Flight</strong> - <span class="wego-dataheader">{{outbound_day}}</span>
          </td>
          <td colspan="2" class="wego-duration">
            Duration: <strong>{{duration}}</strong>
          </td>
        </tr>
        {{#trips}}
        {{#layover}}
        <tr>
          <td class="layover-note" colspan="4">{{time}} layover in {{place}}</td>
        </tr>
        {{/layover}}
        <tr>
          <td class="wego-airline-cell">
            <img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"> <strong>{{designator_code}}</strong>{{#operating_airline_name}}<span class="wego-codeshare-star">*</span>{{/operating_airline_name}}
          </td>
          <td>
            <strong title="{{departure_time}} ({{departure_name}})">{{departure_time}}</strong><br>
            Departs from {{departure_name}} ({{departure_code}})
          </td>
          <td>
            <strong title="{{arrival_time}} ({{arrival_name}})">{{arrival_time}}</strong><br>
            Arrives at {{arrival_name}} ({{arrival_code}})
          </td>
          <td>
            <strong>{{duration}}</strong>
            <br>
            {{aircraft_type}}
          </td>
        </tr>
        {{#operating_airline_name}}
        <tr>
          <td colspan="2"><span class="wego-codeshare-star">*</span> Operated by {{operating_airline_name}}</td>
        </tr>
        {{/operating_airline_name}}
        {{/trips}}
        {{/outbound}}
        {{#inbound}}
        <tr>
          <td colspan="2" class="wego-flight-date">
            <strong>Return Flight</strong> - <span class="wego-dataheader">{{outbound_day}}</span>
          </td>
          <td colspan="2" class="wego-duration">
            Duration: <strong>{{duration}}</strong>
          </td>
        </tr>
        {{#trips}}
        {{#layover}}
        <tr>
          <td class="layover-note" colspan="4">{{time}} layover in {{place}}</td>
        </tr>
        {{/layover}}
        <tr>
          <td class="wego-airline-cell">
            <img src="http://www.mediawego.com/images/flights/airlines/80x27/{{airline_code}}.gif"> <strong>{{designator_code}}</strong>{{#operating_airline_name}}<span class="wego-codeshare-star">*</span>{{/operating_airline_name}}
          </td>
          <td>
            <strong title="{{departure_time}} ({{departure_name}})">{{departure_time}}</strong><br>
            Departs from {{departure_name}} ({{departure_code}})
          </td>
          <td>
            <strong title="{{arrival_time}} ({{arrival_name}})">{{arrival_time}}</strong><br>
            Arrives at {{arrival_name}} ({{arrival_code}})
          </td>
          <td>
            <strong>{{duration}}</strong>
            <br>
            {{aircraft_type}}
          </td>
        </tr>
        {{#operating_airline_name}}
        <tr>
          <td colspan="2"><span class="wego-codeshare-star">*</span> Operated by {{operating_airline_name}}</td>
        </tr>
        {{/operating_airline_name}}
        {{/trips}}
        {{/inbound}}
      </tbody>
    </table>
  </div>
</script>