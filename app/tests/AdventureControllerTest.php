<?php
/**
 * Created by Artsinity Group LLC.
 * Author: Sergey Dogotar
 * Date: 10.06.2014
 * Time: 17:03.
 */
class AdventureControllerTest extends TestCase
{
    public function testAdminEditPageFillsFormWithExisting()
    {
        $user = User::find(7);

        $this->be($user);

        $response = $this->action('GET', 'AdventureController@edit', ['id' => 1]);
    }
}
