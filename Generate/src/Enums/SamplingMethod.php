<?php

namespace AIGenerate\Services\Generate\Enums;

use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum SamplingMethod: string
{
    use GetEnumAttributeTraits;

    case DPM_PP_2M_KARRAS               = "DPM++ 2M Karras";
    case DPM_PP_SDE_KARRAS              = "DPM++ SDE Karras";
    case DPM_PP_2M_SDE_EXPONENTIAL      = "DPM++ 2M SDE Exponential";
    case DPM_PP_2M_SDE_KARRAS           = "DPM++ 2M SDE Karras";
    case EULER_A                        = "Euler a";
    case EULER                          = "Euler";
    case LMS                            = "LMS";
    case HEUN                           = "Heun";
    case DPM2                           = "DPM2";
    case DPM2_A                         = "DPM2 a";
    case DPM_PP_2S_A                    = "DPM++ 2S a";
    case DPM_PP_2M                      = "DPM++ 2M";
    case DPM_PP_SDE                     = "DPM++ SDE";
    case DPM_PP_2M_SDE                  = "DPM++ 2M SDE";
    case DPM_PP_SDE_HEUN                = "DPM++ 2M SDE Heun";
    case DPM_PP_2M_SDE_HEUN_KARRAS      = "DPM++ 2M SDE Heun Karras";
    case DPM_PP_2M_SDE_HEUN_EXPONENTIAL = "DPM++ 2M SDE Heun Exponential";
    case DPM_PP_3M_SDE                  = "DPM++ 3M SDE";
    case DPM_PP_3M_SDE_KARRAS           = "DPM++ 3M SDE Karras";
    case DPM_PP_3M_SDE_EXPONENTIAL      = "DPM++ 3M SDE Exponential";
    case DPM_FAST                       = "DPM fast";
    case DPM_ADAPTIVE                   = "DPM adaptive";
    case LMS_KARRAS                     = "LMS Karras";
    case DPM2_KARRAS                    = "DPM2 Karras";
    case DPM2_A_KARRAS                  = "DPM2 a Karras";
    case DPM_PP_2S_A_KARRAS             = "DPM++ 2S a Karras";
    case RESTART                        = "Restart";
    case DDIM                           = "DDIM";
    case PLMS                           = "PLMS";
    case UNIPC                          = "UniPC";

}