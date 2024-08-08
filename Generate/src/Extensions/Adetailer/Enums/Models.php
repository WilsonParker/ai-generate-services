<?php

namespace AIGenerate\Services\Generate\Extensions\Adetailer\Enums;

use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum Models: string
{
    use GetEnumAttributeTraits;
    
    case FACE_YOLOV8N                  = "face_yolov8n.pt";
    case FACE_YOLOV8S                  = "face_yolov8s.pt";
    case HAND_YOLOV8N                  = "hand_yolov8n.pt";
    case PERSON_YOLOV8N_SEG            = "person_yolov8n-seg.pt";
    case PERSON_YOLOV8S_SEG            = "person_yolov8s-seg.pt";
    case YOLOV8X_WORLDV2               = "yolov8x-worldv2.pt";
    case MEDIAPIPE_FACE_FULL           = "mediapipe_face_full";
    case MEDIAPIPE_FACE_SHORT          = "mediapipe_face_short";
    case MEDIAPIPE_FACE_MESH           = "mediapipe_face_mesh";
    case MEDIAPIPE_FACE_MESH_EYES_ONLY = "mediapipe_face_mesh_eyes_only";
}