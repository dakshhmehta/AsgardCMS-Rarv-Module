<?php

namespace Modules\Rarv\Http\Controllers\Api;

use Illuminate\Routing\Controller;

class EventsController extends Controller
{
    public function trigger($action, $id)
    {
        $action = explode('.', $action);
        $module = ucfirst($action[0]);

        unset($action[0]);

        $action = implode('\\', $action);

        $classPath = 'Modules\\'.$module.'\\Events\\'.$action;

        $data = [
            'errors' => false,
            'message' => 'Notification sent successfully.',
        ];

        try {
            dispatch(new $classPath($id));
        } catch (\Exception $e) {
            $data = [
                'errors' => $e->getMessage(),
                'message' => 'Invalid notification',
            ];
        }


        return response()->json($data);
    }
}
