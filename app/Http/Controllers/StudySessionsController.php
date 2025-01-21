<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudySessionsController extends Controller
{
    public function index($studyId, $scheduleId)
    {
        $study = DB::table('tm_study_material_header as a')
            ->select('a.*', 'a.id AS studyId', 'b.*', 'c.*', 'c.id AS attachmentId') // Select all columns or specify required ones
            ->leftJoin('tm_study_material_detail as b', 'b.header_id', '=', 'a.id')
            ->leftJoin('tm_study_material_attachments as c', 'c.study_material_detail_id', '=', 'b.id')
            ->where(
                [
                    ['a.id', '=', $studyId],
                    ['b.is_active', '!=', 0]
                ]
            )
            ->get();
        foreach ($study as $key => $item) {
            $attachment = $item->attachment;
            if (substr($attachment, 0, 5) == 'https') {
                $videoId = $this->getYoutubeVideoId($attachment);
                $item->attachment = 'ytube.' . $videoId;
            }
        }
        return view('classrooms.studySession', compact('studyId', 'scheduleId', 'study'));
    }

    public function getYoutubeVideoId($url)
    {
        $pattern = '/youtu\.be\/([^\?&]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1]; // The video ID
        }
        return null; // Return null if no match is found
    }

    public function studyMaterialPlayback($scheduleId, $attachmentId)
    {
        $study = DB::table('t_session_material_schedule AS a')
            ->leftJoin('tm_study_material_header AS b', 'b.id', '=', 'a.material_id')
            ->where('a.id', $scheduleId)
            ->get();
        $videoId = substr($attachmentId, 6);
        return view('classrooms.studyMaterialPlayback', compact('study', 'scheduleId', 'attachmentId', 'videoId'));
    }

    public function studyMaterialFile($scheduleId, $attachmentId)
    {
        $study = DB::table('t_session_material_schedule AS a')
            ->leftJoin('tm_study_material_header AS b', 'b.id', '=', 'a.material_id')
            ->where('a.id', $scheduleId)
            ->get();
        $file = DB::table('tm_study_material_attachments AS a')
            ->where('a.id', $attachmentId)
            ->get();
        // $videoId = substr($attachmentId, 6);
        return view('classrooms.studyMaterialFile', compact('study', 'file', 'scheduleId', 'attachmentId'));
    }
}
