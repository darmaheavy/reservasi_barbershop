<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterReservasiTest extends DuskTestCase
{
    public function test_register_dan_reservasi(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/register')

                ->pause(3000)

                ->type('name', 'Testing Dusk')
                ->type('email', 'testing@gmail.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')

                ->screenshot('register-page')

                ->press('Register')

                ->pause(5000)

                ->visit('/reservasi/create')

                ->pause(3000)

                ->screenshot('reservasi-page')

                ->select('layanan_id', 1)
                ->type('tanggal', '2026-05-30')
                ->type('jam', '10:00')

                ->press('Reservasi')

                ->pause(5000)

                ->screenshot('hasil-reservasi');
        });
    }
}