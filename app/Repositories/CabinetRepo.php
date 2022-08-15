<?php


namespace App\Repositories;
use App\Models\Cabinet;
use App\Models\Schedule;
use App\Notifications\UserNotification;
use App\Repositories\Interfaces\CabinetRepo as CabinetRepoInterface;
use Illuminate\Support\Facades\Notification;


class CabinetRepo implements CabinetRepoInterface
{

    public function getAllCabinets()
    {
        return Cabinet::all();
    }

    public function getCabinetById($id)
    {
        return Cabinet::find($id);
    }

    public function createOrUpdate($id = null, $collection = [])
    {
      return  Cabinet::updateOrCreate(
            ['id' => $id],
            $collection
        );
    }

    public function setSchedule($data)
    {
        $schedule = Schedule::whereTime('to', '>',$data['to'])
            ->whereTime('from', '<',$data['from'])
            ->where('date',$data['date'])
            ->where('cabinet_id',$data['cabinet_id'])
            ->where('user_id',$data['user_id'])
            ->with(['user','cabinet'])
            ->get()->first();
        $message = [];
        if (!$schedule) {
            $schedule =  Schedule::create($data);
            $details = array(
                'from' => $schedule->from,
                'to' => $schedule->to,
                'date' => $schedule->date,
                'cabinet_name' => $schedule->cabinet->name,
            );

            Notification::send($schedule->user, new UserNotification($details));
            $message = $schedule->user->notifications->last()->data;
            $status = 1;
        } else {

            $status = 0;

        }
        return ['message' => $message,'status' => $status, 'schedule' => $schedule];
    }

    public function deleteCabinet($id)
    {
        return Cabinet::find($id)->delete();
    }
}
