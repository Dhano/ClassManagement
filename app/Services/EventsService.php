<?php


namespace App\Services;

use App\Event;
use App\EventImage;
use App\NewsFeed;
use App\NewsFeedImage;
use Illuminate\Support\Facades\DB;

/**
 * Class EventsService
 * @package App\Services
 */
class EventsService {

    /**
     * @param $validatedData
     * @param $user_id
     * @return mixed
     */
    public function store($validatedData, $user_id) {
        $event = Event::create([
            'name' => $validatedData['name'],
            'details' => $validatedData['details'],
            'address' => $validatedData['address'],
            'type' => $validatedData['type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'additional_columns' => 'fhdskfjh',
            'created_by' => $user_id
        ]);

        return $event;

    }

    /**
     * @return Event[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDatatable() {
        return Event::all();
    }

    /**
     * @param $id
     * @param $user_id
     */
    public function delete($id, $user_id) {
        DB::beginTransaction();
            $event = Event::findOrFail($id);
            $coordinators = DB::select('SELECT id FROM users WHERE id IN (SELECT staff_id FROM event_staff WHERE event_id = :event_id)', ["event_id" => $id]);
            $finalCoordinators = array();

            foreach ($coordinators as $coordinator) {
                $finalCoordinators[] = $coordinator->id;
            }

            $event->staff()->detach($finalCoordinators);
            $event->save();

            Event::where('created_by', $user_id)
                ->where('id', $id)
                ->delete();
        DB::commit();
    }

    /**
     * @param $validatedData
     * @param $id
     * @param $user_id
     * @return bool
     */
    public function update($validatedData, $id, $user_id) {

        try {
            $event = Event::findOrFail($id);
            $event->name = $validatedData['name'];
            $event->details = $validatedData['details'];
            $event->address = $validatedData['address'];
            $event->type = $validatedData['type'];
            $event->start_date = $validatedData['start_date'];
            $event->end_date = $validatedData['end_date'];
            $event->institute_funding = $validatedData['institute_funding'];
            $event->sponsor_funding = $validatedData['sponsor_funding'];
            $event->internal_participants_count = $validatedData['internal_participants_count'];
            $event->external_participants_count = $validatedData['external_participants_count'];
            $event->expenditure = $validatedData['expenditure'];
            $event->updated_by = $user_id;
            $event->save();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param $event_id
     * @param $coordinators
     * @return bool
     */
    public function addCoordinators($event_id, $coordinators) {
        try {
            DB::beginTransaction();
                $event = Event::findOrFail($event_id);
                $event->staff()->attach($coordinators);
                $event->save();
            DB::commit();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param $event_id
     * @param $coordinator_id
     * @return bool
     */
    public function removeCoordinator($event_id, $coordinator_id) {
        try {
            DB::beginTransaction();
                $event = Event::findOrFail($event_id);
                $event->staff()->detach($coordinator_id);
                $event->save();
            DB::commit();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param $event_id
     * @param $event
     * @param $image_relative_paths
     * @param $user_id
     * @return bool
     */
    public function eventEnd($event_id, $event, $image_relative_paths, $user_id) {
        try {
            DB::beginTransaction();
                // Insert final details about event and end
                $event_row = Event::findOrFail($event_id);
                $event_row->institute_funding = $event['institute_funding'];
                $event_row->sponsor_funding = $event['sponsor_funding'];
                $event_row->expenditure = $event['expenditure'];
                $event_row->internal_participants_count = $event['internal_participants_count'];
                $event_row->external_participants_count = $event['external_participants_count'];
                $event_row->is_completed = 1;
                $event_row->updated_by = $user_id;
                $event_row->updated_at = now();
                $event_row->save();

                foreach ($image_relative_paths as $image_relative_path){
                    EventImage::create([
                        'event_id' => $event_id,
                        'event_image_path' => $image_relative_path,
                        'created_by' => $user_id
                    ]);
                }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param $event_id
     * @return mixed
     */
    public function getImagesPath($event_id) {
        return EventImage::where('event_id', $event_id)->get();
    }

    /**
     * @param $event_id
     * @param $user_id
     * @return bool
     */
    public function publishEventAsNews($event_id, $user_id) {
        $event = Event::findOrFail($event_id);

        $title = $event->name;
        $description = $event->details . '<br> Address: ' . $event->address . '<br> Type: ' . $event->type . '<br> Start Date: ' . $event->start_date . '<br> End date: ' . $event->end_date;

        try {
            DB::beginTransaction();
                $newsFeed = NewsFeed::create([
                    'title' => $title,
                    'description' => $description,
                    'created_by' => $user_id
                ]);

                $id = $newsFeed->id;

                $event_images_path = EventImage::where('event_id', $event_id)->get();

                foreach ($event_images_path as $image_path) {
                    NewsFeedImage::create([
                        'news_feed_id' => $id,
                        'image_path' => $image_path->event_image_path

                    ]);
                }
            DB::commit();

            return true;
        } catch(Exception $exception) {
            return false;
        }
    }

    /**
     * Fetch event details for a given Event id
     *
     * @param $event_id
     * @return mixed
     */
    public function getEventDetailsById($event_id) {
        return Event::findOrFail($event_id);
    }

    /**
     * Fetches unassigned coordinators for the particular event i.e. yet to be assigned
     *
     * @param $event_id
     * @return array
     */
    public function getUnassignedCoordinators($event_id) {
        return DB::select('SELECT id, first_name, last_name FROM users WHERE id NOT IN (SELECT staff_id FROM event_staff WHERE event_id = :event_id)', ["event_id" => $event_id]);
    }

    /**
     * Fetches all coordinators assigned for a particular event
     *
     * @param $event_id
     * @return array
     */
    public function getCoordinatorsForEvent($event_id) {
        return DB::select('SELECT id, first_name, last_name, email FROM users WHERE id IN (SELECT staff_id FROM event_staff WHERE event_id = :event_id)', ["event_id" => $event_id]);
    }

    public function getEventsByStaffId($user_id) {
        return DB::select('SELECT * FROM events WHERE id IN (SELECT event_id FROM event_staff WHERE staff_id = ?)', [$user_id]);
    }

}