<?php

namespace App\Consts;

class CsvOutputContentConsts
{
  // CSV出力の「出力内容」の項目を定義
  public const KINTAI_NORMAL = 'kintai_normal';
  public const KINTAI_BY_CUSTOMER_WORKING_TIME = 'kintai_by_customer_working_time';
  public const CUSTOMER_WORKING_TIME = 'customer_working_time';

  public const OUTPUT_CONTENT_LIST = [
    self::KINTAI_NORMAL => '勤怠情報【通常】',
    self::KINTAI_BY_CUSTOMER_WORKING_TIME => '勤怠情報【荷主稼働時間別】',
    self::CUSTOMER_WORKING_TIME => '荷主稼働時間',
  ];
}