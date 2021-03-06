<?php


namespace learn\services\sms;

use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsVoicePromptSender;
use Qcloud\Sms\SmsVoiceVerifyCodeSender;

class QCloudSmsService
{
    /**
     * APPID
     * @var int
     */
    protected $appId = 0;

    /**
     * APPKEY
     * @var string
     */
    protected $appKey = "";

    /**
     * 短信发送助手
     * @var null
     */
    protected $smSender = null;

    /**
     * 需要发送短信的手机号
     * @var array
     */
    protected $phoneNumbers = [];

    /**
     * QCloudSmsService constructor.
     * @param int $appId
     * @param string $appKey
     */
    public function __construct(int $appId, string $appKey)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;
    }

    /**
     * 发送单条短信
     * @param int $templId
     * @param array $params
     * @param string $sign
     * @return bool
     */
    public function sendSingleSms(int $templId, array $params, string $sign)
    {
        try {
            $this->smSender = new SmsSingleSender($this->appId,$this->appKey);
            $res = json_decode($this->smSender->sendWithParam("86", $this->phoneNumbers[0], $templId, $params, $sign, "", ""),true);
            return $res['result'] == 0 ? true : false;
        }catch (\Exception $e)
        {
            var_dump($e);
            return false;
        }
    }

    /**
     * 发送多条短信
     * @param int $templId
     * @param array $params
     * @param string $sign
     * @return bool
     */
    public function sendMultiSms(int $templId, array $params, string $sign)
    {
        try {
            $this->smSender = new SmsMultiSender($this->appId,$this->appKey);
            $res = json_decode($this->smSender->sendWithParam("86", $this->phoneNumbers, $templId, $params, $sign, "", ""),true);
            return $res['result'] == 0 ? true : false;
        }catch (\Exception $e)
        {
            var_dump($e);
            return false;
        }
    }

    /**
     * 发送语言短信验证码
     * @param string $verifyCode
     * @return bool
     */
    public function sendVoiceVerifySms(string $verifyCode)
    {
        try {
            $this->smSender = new SmsVoiceVerifyCodeSender($this->appId,$this->appKey);
            $res = json_decode($this->smSender->send("86", $this->phoneNumbers[0], $verifyCode),true);
            return $res['result'] == 0 ? true : false;
        }catch (\Exception $e)
        {
            var_dump($e);
            return false;
        }
    }

    /**
     * 发送语言通知
     * @param string $msg
     * @return bool
     */
    public function sendVoicePromptSms(string $msg)
    {
        try {
            $this->smSender = new SmsVoicePromptSender($this->appId,$this->appKey);
            $res = json_decode($this->smSender->send("86", $this->phoneNumbers[0], 2, $msg),true);
            return $res['result'] == 0 ? true : false;
        }catch (\Exception $e)
        {
            var_dump($e);
            return false;
        }
    }

    /**
     * 设置发送的手机号
     * @param array $phone
     */
    public function setPhoneNumbers(array $phone)
    {
        $this->phoneNumbers = is_array($phone) ? $phone : [$phone];
    }
}