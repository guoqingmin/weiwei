<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092600603217",

		//商户私钥
		'merchant_private_key' => "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCJCvEr/hhgTNBQtptQ53W9zDd/qPPVzE21cr9HsWDecG6LUmLOckAKqXzYGq/5IX2tDScgG/EgZ8e14pn9uSM7mgN3qAdmhFUGAyL9Fif3DAqRD3eQd1+9NoAQBiu3BePhgwZBuVaOMB2+kJM/xtkri02ymLwAYd2p+C2HIgqbCCW6migfObG1maH+8QJ6BK8zbtnbQtllFKhiuQYuEvgP5lE+W+9DC04PBSKkNnI3HvBSwig4HkwXfNqmfSaQcx0PYK2P04+ltQEvvtD2tNfyS8l9o20CfMkeduXAdEGXoUaX8Q72vO9uvzUCsrraLPZLEBR6axJKxWMQgvPvAyjvAgMBAAECggEASPJ3H+i4hwI8XMpm8HDUfrwmyqBfcu22a6Bx6zKjEqScYzLuf1/XcRV46/uAskc+g5AdxHy7JHm5l7rQJ3uWIpK/x8C8d7h3HaUrybYyfdF+CmtGRLMWVjydfGoceOb8vzykZvXF+hforVh92RP646/aIvgkErwFZwVBDs5zAMRRxs+SHidOl2yzKKRVyhyvqHyZxLMqm3gKEcBv1lvAIkNze2HCGWPqspnU8SQpFbOcjK8fXNPl64vjFS1IRJNcnn6pMRb7+CbhrAgq2tqxtcWzT1byUAxTLeEnlIfzD4dCGHnpzGADwBOSEk+Fs6tDb5TNQyIO0NfhHF+T8jfrKQKBgQDgkDSaI33TUxhWm1sw2Oy3ey5/hVBStSjTvfQ026U8NGI4nsl9h+3bfBCijHgxGdAcHiM++k0XxjgX4rpxS0GMwEM+VoTE33Drjh8MwrmWWliHdARvor5hOiCzd/CA+JoUoEy+g/ASdCFH2yGCuTvyWQfO2cus2cFm76fZ13nSowKBgQCcOjc6U99LAnzBTMQ7JvMo8cZyDv4tX82dUEr1kV2jGP4oWcoaO+7igLj9Q5T/CIF76kVADhndGswN4UuB2ebQOF8I4me6P1X/so/yFwNF4DGY19uE9zI/g7tJbGzFhQ4gGa1h60at/3U4Hf5e2Dud5hksZ+T8lXXVRupCvaZBRQKBgCknBBzDKEnTzoAAlGONPUQalNjVq3ScslCrXNda8RrpVp6dqrsQb+xq/flr2JLW8iZU94yQ/hO/RYRLDnO4oNiUWz5PSKFzeRQRxWrnPG9rOxIHltCGeHEE3/1Dm5Vm+YWSIr4/G32mPnsWkzuLiorM+ftUOlkAxsqAXLg1HqQVAoGAGOdSzHJ4Qs3Hs0yYb1F7K4i2+JGZRQRjk3MsL88XXRtr0GTXyazKHMMmOgEe7DSf52/l0BsvVkaiRogmcDGbEJAb3h+xJ0hXXiZJue6fL/FYFqQ6Mwzwrp1CKqclA6t9H/LX56cIok35kpN9bAMOJdJ7Ks/4+aadnPzr9O2kZf0CgYBDIu61I/VFbIhw0t2wwpryUW6DUVmFyZ6jY0wyNBeGNr7V23pVpt+32MlVCcDt9xgMEcolMp+oE7J9k4O30OIuP4Gu+EoR9I4uMUWiDEfUs+mOqO/gV0kVrUr1HwVKmwlqcTHG2/Rb649JoQZPbekgLUG4bAqUGQE/AtORuTAQuA==",
		
		//异步通知地址
		'notify_url' => "http://39.107.119.88/notify_url",
		
		//同步跳转
		'return_url' => "http://www.weiwei.com/returnalipay",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiQrxK/4YYEzQULabUOd1vcw3f6jz1cxNtXK/R7Fg3nBui1JiznJACql82Bqv+SF9rQ0nIBvxIGfHteKZ/bkjO5oDd6gHZoRVBgMi/RYn9wwKkQ93kHdfvTaAEAYrtwXj4YMGQblWjjAdvpCTP8bZK4tNspi8AGHdqfgthyIKmwglupooHzmxtZmh/vECegSvM27Z20LZZRSoYrkGLhL4D+ZRPlvvQwtODwUipDZyNx7wUsIoOB5MF3zapn0mkHMdD2Ctj9OPpbUBL77Q9rTX8kvJfaNtAnzJHnblwHRBl6FGl/EO9rzvbr81ArK62iz2SxAUemsSSsVjEILz7wMo7wIDAQAB",
);