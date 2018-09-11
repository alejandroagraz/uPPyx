@extends('layouts.auth')

@section('content')
    <div class="container-fluid container-login">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-login">
                <div class="panel-body">
                    {{ csrf_field() }}
                    <div class="form-group text-center logo-group">
                        <img src="{{ asset('images/logo.png') }}" alt="uPPyx" class="img-responsive">
                    </div>
                    <div class="row style-policy text-justify">
                        <p class="text-center font-policy" style="font-size: 16px;"><strong>PRIVACY POLICY</strong></p>
                        <p>Uppyx Corp (&ldquo;Uppyx,&rdquo; &ldquo;we,&rdquo; or &ldquo;us&rdquo;) knows you care how information about you is collected, used, shared, and protected. This notice describes our current privacy policy (the &ldquo;Policy&rdquo;), which applies to everyone using the Uppyx mobile application (the &ldquo;App&rdquo;). If you do not accept the terms of this Policy and the referenced documents, do not continue using the App.
                        </p>
                        <p>This Policy outlines:
                        </p>
                        <p>1. What Information We Collect About You
                        </p>
                        <p>2. How We Use and Share that Information
                        </p>
                        <p>3. How We Protect that Information and How You Can Help
                        </p>
                        <p>4. What Choices You Have
                        </p>
                        <p class="font-policy"><strong>What Personal Information Does Uppyx Gather About You?</strong>
                        </p>
                        <p>Some types of information gathered include:
                        </p>
                        <p><u>Information You Provide</u>&nbsp;: We receive and store information you submit through use of our App or give us in any way. Such information includes, but is not limited to, information you provide when creating your user account, such as your name, address, phone number, email address, login and password details, and payment information. Other such information includes, but is not limited to, content you upload, such as comments, feedback, and other material of any kind (&ldquo;User Generated Content&rdquo;). Collected information is used to enhance and customize your experience with the App, to respond to your requests related to the App, and to communicate with you. You can choose not to provide certain information, but then you might not be able to take full advantage of many of our features.
                        </p>
                        <p><u>Automatic Information</u>&nbsp;: We receive and store information automatically when you interact with us through use of &ldquo;cookies&rdquo; and other similar technology. We may also collect and store server logs, including but not limited to, device IP address, access dates and times, features used, other system activity, and third-party sites or services you were using before interacting with our App.
                        </p>
                        <p><u>Transaction and Payment Information</u>&nbsp;: We collect transaction details related to your obtaining and receiving car rental services with third party providers via the App. Examples of such information includes, but is not limited to, the date and time of car rental reservation, type of vehicle reserved, date and time the vehicle was delivered to and dropped off by you, amounts charged, and other related transaction details.
                        </p>
                        <p><u>Device Information</u>&nbsp;: We may collect information about your mobile device, including but not limited to, the hardware model, operating system, operating version, software and file names, preferred language, unique device identifier, advertising identifiers, and mobile network information.
                        </p>
                        <p><u>Information from Other Sources</u>&nbsp;: We receive device and location identifiers when you access the App using a mobile device. If you permit the App to access location services through your mobile operating system, we may also collect the precise location of your device when the App is running in the foreground or background. You can disable these functions at any time. However, by doing so, the App may not recognize you as a registered user and will affect your experience.
                        </p>
                        <p class="font-policy"><strong>How Does Uppyx Use and Share This Information?</strong>
                        </p>
                        <p>We may use and share your information (including aggregate and anonymized information) as follows:
                        </p>
                        <p><u>Improve User Experience</u>&nbsp;: We may monitor and analyze activity, metrics, and trends, and use your information to facilitate payments, send receipts, coordinate requested car rental requests and reservations between you and third party providers; to develop, maintain, and improve your user experience; to streamline the App by storing your access credentials and log file; and to make suggestions and provide a customized experience via research and development, marketing and advertising; to fix technical errors, update the App, and other internal operations; and to communicate with you.
                        </p>
                        <p><u>Facilitate Coordination of Services</u>&nbsp;: We may share your information with third party providers in order to enable them to communicate with you and provide you with requested services, including but not limited to, car rental reservations, delivery, and drop-off.
                        </p>
                        <p><u>Uppyx Service Providers</u>&nbsp;: We may employ other companies (including affiliates within our network) to perform functions on our behalf. These service providers and affiliate companies have access to personal and business information needed to perform their functions, but are not authorized to use it for other purposes. We do not provide any of your non-public information (such as payment information, password details, or your IP address) to third parties without your consent, unless required by law.
                        </p>
                        <p><u>Protection of Uppyx and Others</u>&nbsp;: We will use collected information to enhance the safety and security of the App and our other users. In addition, we reserve the right to disclose information and any User Generated Content when we believe that doing so is reasonably necessary to comply with the law or law enforcement, to prevent fraud or abuse, or to protect Uppyx&rsquo;s rights.
                        </p>
                        <p><u>In a Merger or Sale</u>&nbsp;: Your information may be shared as a company asset in the event of a potential sale, merger, acquisition, or other change of ownership or control of Uppyx, whether in part or whole.
                        </p>
                        <p class="font-policy"><strong>How Does Uppyx Protect Your Information and How Can You Help?</strong>
                        </p>
                        <p>Uppyx works to protect your information during transmission by using Secure Sockets Layer (&ldquo;SSL&rdquo;) software, which encrypts information you input. SSL is used to prevent unauthorized access, maintain data accuracy, and to ensure the correct usage of&nbsp;information
                        </p>
                        <p>You agree that information you provide may be seen by others and used by us as described in this Privacy Policy and our Terms and Conditions (as they may change from time to time) which are hereby incorporated by reference in their entirety. We will never ask for your username and password, and you should not share such information with others. Remember to sign off after using any shared computer.
                        </p>
                        <p class="font-policy"><strong>What Choices Do You Have?</strong>
                        </p>
                        <p>You may access a broad range of information about your user account through the App. You may update your information or deactivate and delete your account at anytime. Uppyx may, in its sole discretion, comply with your requests regarding access, correction, and/or deletion of personal data it stores in accordance with applicable law.
                        </p>
                        <p class="font-policy"><strong>Are Children Allowed to Use the Website?</strong>
                        </p>
                        <p>Use of the App is intended for people 25 years of age and over. Users under the age of 25 may not use the App. We do not knowingly collect, share, or store any information from users under 25 years of age.
                        </p>
                        <p class="font-policy"><strong>Conditions of Use, Notices, and Modifications</strong>
                        </p>
                        <p>If you choose to use the App, your visit, use, or any dispute over privacy is subject to this Privacy Policy and our Terms and Conditions, including limitations on damages, resolution of disputes, and application of the law of the State of Florida. If you have any concern about privacy relating to the App, please email us at info@uppyx.com.
                        </p>
                        <p>Uppyx reserves the right to change the App and the terms of this Policy at any time. If modifications are made, we will provide you notice of such modifications and when they go into effect. It is your responsibility to review these notices and any modifications to this Policy. If you use (or continue to use) the Service after a change, that means you accept the new Policy terms.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection