<?php

use Illuminate\Database\Migrations\Migration;

class AddFaqPage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $page = new PageContent();
        $page->id = 14;
        $page->page_id = 14;
        $page->title = 'FAQ';
        $page->sub_title = '';
        $page->content = '<h3>From 01 October 2015 the Emperors Visits tour will cease operating and all Visits overnight boat tours will no longer offer on-board diving.</h3>

<div class="faq-section">
    <h2>Sailing Tours</h2>
</div>
<div class="row">
    <div class="col-md-12">
        <h5>Do I require a diving certification to dive with Visits?</h5>
        <p>No, We have a dive instructor on board for the duration of the trip to guide you through your dives.</p>

        <h5>If I have, or have had any medical conditions, can I go diving?</h5>
        <p>Certain medical conditions (current or previous) can prevent people from diving. If you are unsure, a dive medical from a doctor will clarify that you are physically fit to dive. Passengers over 50 or people on medication may need to be approved by a doctor for a dive medical. Where a dive medical may be required allow yourself time to see a doctor prior to your trip. Any questions please contact Visits office.</p>

        <h5>Do you offer guided dives for certified divers or do we just dive with a buddy?</h5>
        <p>All dives are guided by your Visits instructor.</p>

        <h5>Can I dive if I have never dived before?</h5>
        <p>Yes, our dive instructors are trained to take inexperienced divers.</p>

        <h5>I am a certified diver but have not dived for along time, do I need to do a refresher course?</h5>
        <p>No, our instructors will give you a refresher course prior to diving.</p>

        <h5>Do you offer night dives?</h5>
        <p>Yes, you require your advanced diving certificate.</p>

        <h5>How big are the dive groups?</h5>
        <p>Intro groups of 2 passengers per instructor and certified groups of maximum 6 passengers per instructor.</p>

        <h5>Is all required dive gear included with your dive prices?</h5>
        <p>Yes, packaged or onboard dive prices include all equipment and gear.</p>

        <h5>Can I bring my own dive gear?</h5>
        <p>Yes, the price does not change and you will need to fill out a dive gear indemnity form on board.</p>

        <h5>Can I just snorkel?</h5>
        <p>Yes of course, all snorkel equipment is included on all tour.</p>

        <h5>Do you have private cabins?</h5>
        <p>No, all cabins are shared with double beds and single beds.</p>

        <h5>Is your vessel family friendly?</h5>
        <p>Yes, majority 20yrs - 35yrs but not a party tour.</p>

        <h5>How young is too young?</h5>
        <p>Under 12 yrs and a life jacket is a requirement throughout the duration of the trip. We do not recommend under 12.</p>

        <h5>What is the youngest age for diving?</h5>
        <p>Passenger needs to be 12 or over to dive.</p>

        <h5>Is your tour a party tour?</h5>
        <p>No, we turn music off at 10pm and concentrate on diving and passengers can not dive hungover. We are a lot of fun with new friends made and light sunset drinks together!</p>

        <h5>How many dives can I do with Visits?</h5>
        <p>Visits tours can offer up to 8 dive opportunities for all passengers.</p>

        <h5>Is there an age limit to diving?</h5>
        <p>No, over 45 years will require written consent from a doctor to participate in diving activities.</p>
    </div>
</div>

<div class="faq-section">
    <h2>Adventure Park</h2>
</div>

<div class="row">
    <div class="col-md-12">
        <h5>Who can drive?</h5>
        <p>Any one with a current drivers licence or learners permit from any country and must not be under the influence of alcohol or drugs.</p>

        <h5>Who can be a passenger?</h5>
        <p>8 years or over, kids protective wear available.</p>

        <h5>What facilities are available at the park?</h5>
        <p>We have running water, a bathroom and sheltered area with benches, cold drinks and snacks available for purchase.</p>

        <h5>What do we need?</h5>
        <p>Change of clothes, towel, sunscreen, enclosed shoes and a sense of adventure! If you choose to bring your camera or phones on the mini 4wd they may get lost wet or damaged. There will be storage area at the mud pit challenge area for personal items. This is not secure so please leave valuable items at home.</p>

        <h5>Do both passenger and driver get to drive?</h5>
        <p>Yes, we provide time for change over if both passengers want to drive.</p>

        <h5>Will I get wet and muddy?</h5>
        <p>Yes! If you drive slower you can avoid some mud-pits and not get too wet or muddy but you will get some mud spots guaranteed.</p>
    </div>
</div>';
        $page->keywords = 'faq';
        $page->description = 'Visits FAQ';
        $page->backgroundUrl = null;
        $page->save();

        $page = new PageName();
        $page->id = 14;
        $page->name = 'FAQ';
        $page->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        /** @var PageContent $delete */
        $delete = PageContent::find(14);
        $delete->delete();

        /** @var PageContent $delete */
        $delete = PageName::find(14);
        $delete->delete();
    }
}
