<?php

namespace App\Enums;

enum PhoneCallStatus
{
    case WaitingReceiver;
    case Canceled;
    case TalkStarted;
    case Finished;
}
