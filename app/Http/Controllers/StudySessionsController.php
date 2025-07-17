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

    public function studyMaterialPlayback($scheduleId, $attachmentId, $attachmentIndex, $attachmentOri)
    {
        $study = DB::table('t_class_activity AS a')
            ->leftJoin('tm_study_material_header AS b', 'b.id', '=', 'a.activity_id')
            ->where('a.id', $scheduleId)
            ->get();
        $studyHeaderId = DB::table('tm_study_material_attachments AS a')
            ->leftJoin('tm_study_material_detail AS b', 'b.id', '=', 'a.study_material_detail_id')
            ->select('b.header_id')
            ->where('a.id', $attachmentOri)
            ->first();
        $allAttachments = DB::table('tm_study_material_header AS a')
            ->leftJoin('tm_study_material_detail AS b', 'b.header_id', '=', 'a.id')
            ->leftJoin('tm_study_material_attachments AS c', 'c.study_material_detail_id', '=', 'b.id')
            ->where([
                'a.id' => $studyHeaderId->header_id,
                'b.is_active' => 1
            ])
            ->get();
        $videoId = substr($attachmentId, 6);

        if ((intval($attachmentIndex) - 1) != -1) {
            $prevAttachment = $allAttachments[intval($attachmentIndex) - 1];
            $prevIndex = intval($attachmentIndex) - 1;
            if ($prevAttachment != null && substr($prevAttachment->attachment, 0, 5) == 'https') {
                $prevVideoId = $this->getYoutubeVideoId($prevAttachment->attachment);
                $prevAttachment->attachment = 'ytube.' . $prevVideoId;

                $prevType = 'link';
            } else {
                $prevType = 'file';
            }
        } else {
            $prevAttachment = '';
            $prevIndex = '';
            $prevType = '';
        }
        if ((intval($attachmentIndex) + 1) < count($allAttachments)) {
            $nextAttachment = $allAttachments[intval($attachmentIndex) + 1];
            $nextIndex = intval($attachmentIndex) + 1;
            if ($nextAttachment != null && substr($nextAttachment->attachment, 0, 5) == 'https') {
                $nextVideoId = $this->getYoutubeVideoId($nextAttachment->attachment);
                $nextAttachment->attachment = 'ytube.' . $nextVideoId;

                $nextType = 'link';
            } else {
                $nextType = 'file';
            }
        } else {
            $nextAttachment = '';
            $nextIndex = '';
            $nextType = '';
        }
        return view('classrooms.studyMaterialPlayback', compact('study', 'scheduleId', 'attachmentId', 'videoId', 'prevAttachment', 'prevType', 'prevIndex', 'nextAttachment', 'nextType', 'nextIndex'));
    }

    public function studyMaterialFile($scheduleId, $attachmentId, $attachmentIndex)
    {
        $study = DB::table('t_class_activity AS a')
            ->leftJoin('tm_study_material_header AS b', 'b.id', '=', 'a.activity_id')
            ->where('a.id', $scheduleId)
            ->get();
        $file = DB::table('tm_study_material_attachments AS a')
            ->where('a.id', $attachmentId)
            ->get();

        $studyHeaderId = DB::table('tm_study_material_attachments AS a')
            ->leftJoin('tm_study_material_detail AS b', 'b.id', '=', 'a.study_material_detail_id')
            ->select('b.header_id')
            ->where('a.id', $attachmentId)
            ->first();
        $allAttachments = DB::table('tm_study_material_header AS a')
            ->leftJoin('tm_study_material_detail AS b', 'b.header_id', '=', 'a.id')
            ->leftJoin('tm_study_material_attachments AS c', 'c.study_material_detail_id', '=', 'b.id')
            ->where([
                'a.id' => $studyHeaderId->header_id,
                'b.is_active' => 1
            ])
            ->get();

        if ((intval($attachmentIndex) - 1) != -1) {
            $prevAttachment = $allAttachments[intval($attachmentIndex) - 1];
            $prevIndex = intval($attachmentIndex) - 1;
            if ($prevAttachment != null && substr($prevAttachment->attachment, 0, 5) == 'https') {
                $prevVideoId = $this->getYoutubeVideoId($prevAttachment->attachment);
                $prevAttachment->attachment = 'ytube.' . $prevVideoId;

                $prevType = 'link';
            } else {
                $prevType = 'file';
            }
        } else {
            $prevAttachment = '';
            $prevIndex = '';
            $prevType = '';
        }
        if ((intval($attachmentIndex) + 1) < count($allAttachments)) {
            $nextAttachment = $allAttachments[intval($attachmentIndex) + 1];
            $nextIndex = intval($attachmentIndex) + 1;
            if ($nextAttachment != null && substr($nextAttachment->attachment, 0, 5) == 'https') {
                $nextVideoId = $this->getYoutubeVideoId($nextAttachment->attachment);
                $nextAttachment->attachment = 'ytube.' . $nextVideoId;

                $nextType = 'link';
            } else {
                $nextType = 'file';
            }
        } else {
            $nextAttachment = '';
            $nextIndex = '';
            $nextType = '';
        }
        return view('classrooms.studyMaterialFile', compact('study', 'file', 'scheduleId', 'attachmentId', 'prevAttachment', 'prevType', 'prevIndex', 'nextAttachment', 'nextType', 'nextIndex'));
    }
}
