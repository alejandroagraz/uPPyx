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
                        <p class="text-center font-policy" style="font-size: 16px;"><strong>TERMS &amp;
                                CONDITIONS</strong></p>
                        <p>
                            Welcome to Uppyx!
                        </p>
                        <p>
                            Uppyx Corp ("Uppyx") is a Florida corporation that provides the Uppyx
                            mobile application service. Specifically, Uppyx is a mobile application
                            which enable users like you to arrange car rental reservations with third
                            party providers (the "App"). Uppyx is a conduit between users and third
                            party providers, and is not itself a car rental company, transportation,
                            logistics or delivery service provider.
                        </p>
                        <p>
                            Uppyx provides this Service to you subject to the notices, terms, and
                            conditions set forth in this agreement (the "Agreement"). Your use of the
                            App is also subject to our Privacy Policy (as it may change from time to
                            time) which is hereby incorporated by reference in its entirety and can be
                            reviewed by visiting [include link to Privacy Policy].
                        </p>
                        <p>
                            When you use the App, including but not limited to, creating a user account
                            and reserving a vehicle, you will be subject to and agree to be bound by
                            this Agreement and the Privacy Policy. In the event that any of the terms,
                            conditions, or notices contained herein conflict with the Privacy Policy or
                            other terms and guidelines, these terms shall control. PLEASE BE AWARE THAT
                            THIS AGREEMENT AND THE REFERENCED DOCUMENTS DESCRIBE OUR COMPLETE TERMS OF
                            USE. USING THE APP INDICATES YOUR ACCEPTANCE OF ALL THE TERMS AND
                            CONDITIONS SET FORTH. IF YOU DO NOT AGREE TO THESE TERMS, AS THEY MAY
                            CHANGE PERIODICALLY, YOU MAY NOT USE THE UPPYX APP. Uppyx reserves the
                            right to terminate these Terms or your access to the, or generally cease
                            offering the App or any portion thereof, at any time for any reason.
                        </p>
                        <p>
                            <strong>
                                IMPORTANT: PLEASE REVIEW THE DISPUTE RESOLUTION PROVISION BELOW
                                CAREFULLY, AS IT WILL REQUIRE YOU TO RESOLVE DISPUTES WITH UPPYX ON AN
                                INDIVIDUAL BASIS THROUGH BINDING ARBITRATION. BY ENTERING INTO THIS
                                AGREEMENT, YOU EXPRESSLY ACKNOWLEDGE THAT YOU HAVE READ AND UNDERSTAND
                                ALL OF THE TERMS OF THIS AGREEMENT AND HAVE TAKEN TIME TO CONSIDER THE
                                CONSEQUENCES OF THIS IMPORTANT DECISION.
                            </strong>
                        </p>
                        <p class="font-policy">
                            <strong>MODIFICATION</strong>
                        </p>
                        <p>
                            Uppyx reserves the right to change the App, any services, and the terms of
                            this Agreement at any time. If modifications are made, Uppyx will provide
                            you notice of such modifications. It is your responsibility to review these
                            notices and any modifications. If you use (or continue to use) the App
                            after a change, that means you accept the new terms.
                        </p>
                        <p class="font-policy">
                            <strong>USE OF SERVICE</strong>
                        </p>
                        <p>
                            By downloading, accessing, or using the App, you agree to the following:
                        </p>
                        <p>
                            1. You represent and warrant that you are at least 25 years old. You may
                            not authorize others to use your account, and you may not allow persons
                            under the age of 25 to obtain services via your account. You also represent
                            and warrant that you are not a person or entity barred from accessing the
                            App under the laws of any jurisdiction.
                        </p>
                        <p>
                            2. Subject to the terms of this Agreement, Uppyx hereby grants you a
                            limited, revocable, non-transferable and non-exclusive license to access
                            and use the App on your mobile device only for its intended purpose. Any
                            breach of this Agreement shall result in the immediate revocation of the
                            license granted herein and deletion of your account without notice to you.
                            You may, at your sole discretion and without notice to Uppyx, deactivate
                            and/or delete your user account at any time. Any rights not expressly
                            granted herein are reserved by Uppyx.
                        </p>
                        <p>
                            3. You agree that Uppyx and third party providers may contact you by
                            telephone, text message, and email in order to effectuate services
                            requested by you via the App, including arranging and coordinating car
                            rental reservations, delivery, and return.
                        </p>
                        <p>
                            4. Uppyx respects other people's rights, including intellectual property
                            rights, and expects our users to do the same. You may not reproduce,
                            distribute, display, sell, lease, transmit, create derivative works from,
                            translate, modify, reverse-engineer, disassemble, decompile, or otherwise
                            exploit the App or any portion of it unless expressly permitted by Uppyx in
                            writing. You may not make any commercial use of any of the information
                            provided on the App or make any use of the App for the benefit of another
                            business. Any violation of any person or entity's intellectual property
                            rights will result in the immediate termination of services and deletion of
                            your user account.
                        </p>
                        <p>
                            5. Uppyx may assign you a password and account identification (the "Login
                            Credentials"), which enable you to access and use the App. You will be
                            deemed to be authorized to access and use the App in a manner consistent
                            with this Agreement each time you use your Login Credentials. Uppyx shall
                            have no obligation to investigate the authorization or source of any access
                            or use of the App. YOU WILL BE SOLELY RESPONSIBLE FOR ALL ACCESS TO AND USE
                            OF THE APP BY ANYONE USING THE LOGIN CREDENTIALS ASSIGNED TO YOU, WHETHER
                            OR NOT SUCH ACCESS TO AND USE IS ACTUALLY AUTHORIZED BY YOU, INCLUDING
                            WITHOUT LIMITATION, ALL COMMUNICATIONS, TRANSMISSIONS, AND OBLIGATIONS
                            (INCLUDING CAR RENTAL RESERVATIONS AND FINANCIAL OBLIGATIONS) INCURRED
                            THROUGH SUCH ACCESS OR USE. You are solely responsible for protecting the
                            security and confidentiality of the Login Credentials assigned to you and
                            you shall immediately notify Uppyx of any unauthorized use of your Login
                            Credentials.
                        </p>
                        <p>
                            6. You are responsible for obtaining the data network access necessary to
                            use the App. In addition to any charges and other fees incurred through use
                            of the App, either from Uppyx or any third party provider, your mobile
                            network's data and messaging rates and fees may apply. You are responsible
                            for acquiring and updating compatible hardware or devices necessary to
                            access and use the App, and the App may be subject to malfunctions and
                            delays inherent in the use of the Internet and electronic communications.
                        </p>
                        <p>
                            7. Uppyx reserves the right to refuse service, terminate accounts, edit
                            User Generated Content (defined below and for formatting purposes only),
                            remove User Generated Content, and cancel reservations at its discretion,
                            without limitation, for any reason or no reason at all, or if it believes
                            that your conduct violates this Agreement, the Privacy Policy, applicable
                            law, or is otherwise harmful to Uppyx, its affiliates, third party
                            providers, or App users.
                        </p>
                        <p class="font-policy">
                            <strong>RESERVATIONS AND CANCELLATIONS</strong>
                        </p>
                        <p>
                            The Uppyx App enables you to schedule and coordinate the reservation,
                            delivery, and return of rental vehicles with third party providers. Through
                            the App, you will be able to specify a vehicle class; designate when and
                            where you would like a rental vehicle to be delivered to you; and where,
                            within the designated territory you will drop off the vehicle. Uppyx will
                            provide all relevant information to third party providers, who will meet
                            you at the designated location and time, with the reserved vehicle. You
                            will receive confirmation of your reservation and receipt for payment via
                            the App.
                        </p>
                        <p>
                            In order to reserve a vehicle, you must upload to the App, and maintain at
                            all times, a current and valid driver's license.
                        </p>
                        <p>
                            Once confirmed, your reservation cannot be modified. However, you can
                            cancel your reservation, without incurring a fee, at any time between
                            reservation and up to 24 hours prior to the scheduled delivery time. You
                            may incur a cancellation fee if you cancel your reservation within 24 hours
                            of the scheduled delivery time.
                        </p>
                        <p>
                            All reservations, cancellations, extensions, and rebookings must be made
                            using the Uppyx App.
                        </p>
                        <p class="font-policy">
                            <strong>PAYMENT TERMS</strong>
                        </p>
                        <p>
                            In order to use the services offered via the App, including but not limited
                            to, reserving a car rental, you must provide Uppyx with at least one valid
                            payment method at the time of creating your user account. You may change
                            your payment method and information at any time, so long as at least one
                            valid payment method is kept on file at all times. All payments for rental
                            vehicles will be processed exclusively by Uppyx using the payment method
                            and information designated by you in your user account. After such payment
                            has been made, you will receive a receipt from Uppyx.
                        </p>
                        <p>
                            24 hours prior to the scheduled delivery time, a hold will be placed on
                            your credit or debit card. Payment will be executed upon vehicle delivery
                            (as detailed below). At any time, if your payment method or information is
                            expired, invalid or otherwise not able to be charged, you agree that Uppyx
                            may use your secondary payment method in your account, if available. If you
                            have not provided a secondary payment method, Uppyx reserves the right to
                            request secondary payment information from you or cancel any pending
                            reservations. Payments are final and non-refundable, unless otherwise
                            detailed herein or determined by Uppyx.
                        </p>
                        <p>
                            Uppyx collects payment on behalf of third party providers as their limited
                            payment collection agent. Such payments shall be considered the same as
                            payment made directly by you to the third party provider. This payment
                            structure is intended to fully compensate third party providers, as
                            applicable, for the services or goods obtained by and provided to you in
                            connection with your use of the App.
                        </p>
                        <p class="font-policy">
                            <strong>VEHICLE DELIVERY AND RETURN</strong>
                        </p>
                        <p>
                            On the date and time of your reservation, you will be greeted at the
                            designated location by a third party provider agent holding a placard
                            prominently displaying the "Uppyx" logo and your name. At this time, the
                            agent will verify your identity, and may request to make a copy or take a
                            digital image of your valid driver's license. The agent will also provide
                            you with their rental agreement, including customer care contact
                            information, and may provide a vehicle inspection report.
                        </p>
                        <p>
                            During the reservation process, you will designate, via the App, where,
                            within the specified territory, you intend to return or drop off the
                            vehicle. An agent may contact you if necessary to effectuate vehicle pick
                            up. Uppyx will be notified by the third party provider of vehicle delivery
                            and return.
                        </p>
                        <p>
                            All questions, concerns, or inquiries related to car delivery, use, and
                            return should be directed to the third party provider using customer care
                            contact information provided to you at the time of vehicle delivery. <strong></strong>
                        </p>
                        <p class="font-policy">
                            <strong>USER ACCOUNT AND CONTENT</strong>
                        </p>
                        <p>
                            In order to use most aspects of the App, you must register for and maintain
                            a user account. You must be at least 25 years old to create a user account
                            and use the App. Account registration requires you to submit to Uppyx
                            certain personal information, including but not limited to, your name,
                            address, mobile phone number, age, valid driver's license information, and
                            at least one valid payment method. You agree to maintain accurate,
                            complete, and up-to-date information in your user account at all times.
                            Your failure to maintain such information may result in your inability to
                            obtain services, including making rental car reservations. You are
                            responsible for all activity that occurs within your user account, and you
                            agree to maintain the security of your user account information.
                        </p>
                        <p>
                            Uppyx may, from time to time and in its sole discretion, request or permit
                            you to submit, upload, or otherwise publish text, audio, and/or visual
                            content, including commentary and feedback related to services provided to
                            you by a third party provider ("User Generated Content").
                        </p>
                        <p>
                            You own the User Generated Content that you submit or post through the App,
                            and you grant Uppyx a non-exclusive, perpetual, irrevocable, worldwide,
                            transferable and sub-licensable license and right to use, copy, modify,
                            distribute, publish, and process information and User Generated Content you
                            provide, without any further consent, notice and/or compensation to you or
                            others. Uppyx does not claim ownership of any User Generated Content.
                        </p>
                        <p>
                            You agree and represent and warrant that your User Generated Content: (a)
                            does not violate any law; (b) does not violate or infringe upon the
                            copyrights, patents, trademarks, service marks, trade secrets, or other
                            proprietary rights of any person or entity; (c) is not defamatory, abusive,
                            harassing, threatening, impersonating, or intimidating to any other person
                            or entity; (d) is not libelous, threatening, defamatory, obscene,
                            pornographic, hateful, or could give rise to any civil or criminal
                            liability under U.S. or international law; or (e) does not include any
                            bugs, viruses, worms, trap doors, Trojan horses, or other harmful code or
                            properties.
                        </p>
                        <p>
                            By submitting User Generated Content, you agree that Uppyx can use and
                            share such feedback for any purpose without compensation to you.
                        </p>
                        <p>
                            Submissions and opinions that are User Generated Content are those of the
                            individuals or entities expressing such submissions or opinions, and do not
                            reflect Uppyx's opinions. Uppyx is not responsible for User Generated
                            Content.
                        </p>
                        <p class="font-policy">
                            <strong>INTELLECTUAL PROPERTY</strong>
                        </p>
                        <p>
                            All graphics, images, videos, icons, and text on the App (the "Uppyx
                            Content"), belongs exclusively to Uppyx or its Uppyx Content suppliers,
                            except those of third party providers. All software used on the App is the
                            property of Uppyx or its software suppliers. U.S. and international
                            copyright laws protect the Uppyx Content and Software. The use of any of
                            Uppyx's trademarks or service marks without Uppyx's express written consent
                            is strictly prohibited. You may not use any of Uppyx's trademarks or
                            service marks in connection with any product or service that is in any way
                            likely to cause confusion or harm to Uppyx.
                        </p>
                        <p class="font-policy">
                            <strong>TERMINATION AND EFFECT OF TERMINATION</strong>
                        </p>
                        <p>
                            In addition to any other legal or equitable remedies, Uppyx may, without
                            notice to you, terminate this Agreement or revoke any or all of your rights
                            granted under it at any time. The provisions relating to intellectual
                            property, Disclaimer, Limitation of Liability, Applicable Laws,
                            Indemnification, and Severability shall survive any termination.
                            Termination does not release you from payment obligations.
                        </p>
                        <p class="font-policy">
                            <strong>INTERNATIONAL ACCESS</strong>
                        </p>
                        <p>
                            This Service may be accessed from outside the United States, and may
                            contain products and services or references to products and services that
                            are not available outside of the United States. Any such references do not
                            imply that such products and services will be made available outside the
                            United States. Users who access or use the App from outside the United
                            States are responsible for complying with their local laws and regulations.
                        </p>
                        <p class="font-policy">
                            <strong>DISCLAIMER</strong>
                        </p>
                        <p>
                            THIS SERVICE IS PRESENTED "AS IS" AND MAY INCLUDE INACCURACIES, MISTAKES OR
                            TYPOGRAPHICAL ERRORS. UPPYX DOES NOT WARRANT THAT THE CONTENT WILL BE
                            UNINTERRUPTED OR ERROR FREE NOR DOES UPPYX MAKE ANY WARRANTY AS TO THE
                            RESULTS THAT MAY BE OBTAINED FROM USE OF THIS APP, OR AS TO THE ACCURACY,
                            RELIABILITY OR CONTENT OF ANY INFORMATION, SERVICE, OR MERCHANDISE OBTAINED
                            THROUGH THE APP. PRICE INFORMATION IS SUBJECT TO CHANGE WITHOUT NOTICE. IT
                            IS YOUR RESPONSIBILITY TO EVALUATE THE ACCURACY AND COMPLETENESS OF ALL
                            INFORMATION, OPINIONS AND OTHER MATERIAL ON THE APP OR ANY SITES WITH WHICH
                            IT IS LINKED.
                        </p>
                        <p>
                            UPPYX DOES NOT WARRANT OR MAKE ANY REPRESENTATIONS REGARDING CONTENT OR THE
                            RESULTS OF USE OF THE GOODS OR SERVICES REQUESTED OR OBTAINED THROUGH THE
                            APP. UPPYX (INCLUDING ITS AFFILIATES, THIRD PARTY CONTENT PROVIDERS,
                            MERCHANTS, SPONSORS, LICENSORS AND THE LIKE, AND THEIR RESPECTIVE
                            DIRECTORS, OFFICERS AND EMPLOYEES) MAKES NO REPRESENTATIONS OR WARRANTIES
                            OF ANY KIND WHATSOEVER, EXPRESS OR IMPLIED, IN CONNECTION WITH THESE TERMS
                            AND CONDITIONS OR THE APP, ITS CONTENT, OR ANY OTHER PORTION OF THE APP,
                            INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY,
                            NON-INFRINGEMENT, TITLE OR FITNESS FOR A PARTICULAR PURPOSE, OR WARRANTIES
                            ABOUT THE ACCURACY, RELIABILITY, COMPLETENESS, OR TIMELINESS OF THE APP,
                            GRAPHICS, OR LINKS UNLESS SUCH REPRESENTATIONS AND WARRANTIES ARE NOT
                            LEGALLY EXCLUDABLE UNDER APPLICABLE LAW.
                        </p>
                        <p class="font-policy">
                            <strong>LIMITATION OF LIABILITY</strong>
                        </p>
                        <p>
                            UPPYX SHALL NOT BE LIABLE FOR ANY DAMAGES, LIABILITY OR LOSSES ARISING OUT
                            OF: (a) YOUR USE OF OR RELIANCE ON THE APP OR YOUR INABILITY TO ACCESS OR
                            USE THE APP; (b) ANY TRANSACTION OR RELATIONSHIP BETWEEN YOU AND ANY THIRD
                            PARTY PROVIDER, EVEN IF UPPYX HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH
                            DAMAGES; OR (c) YOUR USE OF ANY VEHICLE PROVIDED BY A THIRD PARTY PROVIDER.
                            UPPYX SHALL NOT BE LIABLE FOR DELAY OR FAILURE IN PERFORMANCE RESULTING
                            FROM CAUSES BEYOND UPPYX'S REASONABLE CONTROL.
                        </p>
                        <p>
                            THE APP MAY BE USED BY YOU TO ARRANGE CAR RENTAL SERVICES WITH THIRD PARTY
                            PROVIDERS, AND YOU AGREE THAT UPPYX HAS NO RESPONSIBILITY OR LIABILITY TO
                            YOU RELATED TO ANY SUCH SERVICES PROVIDED TO AND OBTAINED BY YOU VIA SUCH
                            THIRD PARTY PROVIDERS.
                        </p>
                        <p>
                            IN USING THE APP, YOU AGREE THAT UPPYX WILL NOT BE RESPONSIBLE OR LIABLE,
                            UNDER ANY CIRCUMSTANCES, FOR ANY (a) ACCESS DELAYS OR ACCESS INTERRUPTIONS
                            TO THE APP; (b) DATA NON-DELIVERY, MISDELIVERY, CORRUPTION, DESTRUCTION OR
                            OTHER MODIFICATION; (c) LOSS OR DAMAGES OF ANY SORT INCURRED AS A RESULT OF
                            DEALINGS WITH OR USE OF RENTAL CARS PROVIDED BY ANY THIRD PARTY PROVIDER;
                            (d) COMPUTER VIRUSES, SYSTEM FAILURE OR MALFUNCTION WHICH MAY OCCUR IN
                            CONNECTION WITH YOUR USE OF THE APP, INCLUDING DURING HYPERLINK TO OR FROM
                            THIRD PARTY WEBSITES; OR (e) EVENTS BEYOND UPPYX'S REASONABLE CONTROL.
                        </p>
                        <p>
                            FURTHER, TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, REGARDLESS OF
                            THE FORM OF ACTION, WHETHER IN CONTRACT, TORT OR OTHERWISE, UPPYX WILL NOT
                            BE LIABLE FOR ANY DAMAGES OF ANY KIND ARISING FROM THE USE OF THE APP OR
                            ANY DEALINGS OR RELATIONSHIP WITH ANY THIRD PARTY PROVIDERS, INCLUDING, BUT
                            NOT LIMITED TO INDIRECT, INCIDENTAL, PUNITIVE, EXEMPLARY, SPECIAL OR
                            CONSEQUENTIAL DAMAGES. <a name="OLE_LINK2"></a>
                            <a name="OLE_LINK1">
                                TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, UPPYX'S TOTAL
                                LIABILITY TO YOU FOR ANY DAMAGES (REGARDLESS OF THE FOUNDATION FOR THE
                                ACTION) SHALL NOT EXCEED IN THE AGGREGATE THE AMOUNT OF FEES ACTUALLY
                                PAID BY YOU TO UPPYX THROUGH THE APP DURING THE MONTH IMMEDIATELY
                                PRECEDING THE ACT ALLEGEDLY GIVING RISE TO UPPYX'S LIABILITY.
                            </a>
                        </p>
                        <p>
                            THE LIMITATIONS AND DISCLAIMER IN THIS SECTION DO NOT PURPORT TO LIMIT
                            LIABILITY OR ALTER YOUR RIGHTS AS A CONSUMER THAT CANNOT BE EXCLUDED UNDER
                            APPLICABLE LAW. BECAUSE SOME STATES OR JURISDICTIONS DO NOT ALLOW THE
                            EXCLUSION OF OR THE LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL
                            DAMAGES, IN SUCH STATES OR JURISDICTIONS, UPPYX'S LIABILITY SHALL BE
                            LIMITED TO THE EXTENT PERMITTED BY LAW. THIS PROVISION SHALL HAVE NO EFFECT
                            ON UPPYX'S CHOICE OF LAW PROVISION SET FORTH BELOW.
                        </p>
                        <p class="font-policy">
                            <strong>THIRD PARTY PROVIDERS</strong>
                        </p>
                        <p>
                            The App may be made available or accessed in connection with third party
                            providers (such as rental car companies) that Uppyx does not control. You
                            acknowledge that different terms of use and privacy policies may apply to
                            your dealings with such third party providers. In no event shall Uppyx be
                            responsible or liable for any products or services obtained by you from
                            third party providers. Such third party service providers are not parties
                            to this contract, and your acceptance of the goods and services provided by
                            such third party providers may be governed by different or additional
                            agreements between you and such third party providers. You agree that as
                            between you and such third party providers, Uppyx shall not be responsible
                            for your use and acceptance of such goods and services.
                        </p>
                        <p class="font-policy">
                            <strong>APPLICABLE LAW</strong>
                        </p>
                        <p>
                            The laws of the State of Florida shall govern this Agreement. Any dispute
                            relating in any way to your visit to or use of the App shall be submitted
                            to confidential arbitration in Miami-Dade County, Florida, except in
                            regards to issues regarding violations of Uppyx's intellectual property
                            rights, for which Uppyx may seek relief from any state or federal court of
                            competent jurisdiction in the State of Florida. By using the App, you
                            hereby consent to, and waive all defenses of lack of personal jurisdiction
                            and forum non-conveniences with respect to venue and jurisdiction in the
                            state and federal courts of the State of Florida. Arbitration under this
                            Agreement shall be conducted pursuant to the Commercial Arbitration Rules
                            then prevailing at the American Arbitration Association. The arbitrator's
                            award shall be final and binding and may be entered as a judgment in any
                            court of competent jurisdiction. To the fullest extent permitted by
                            applicable law, no arbitration under this Agreement shall be joined to an
                            arbitration involving any other party subject to this Agreement, whether
                            through class action proceedings or otherwise. In using this Service, you
                            further agree that regardless of any statute or law to the contrary, any
                            claim or cause of action arising out of, related to, or connected with the
                            use of the App or Agreement must be filed within one (1) year after such
                            claim or cause of action arose or be forever banned.
                        </p>
                        <p>
                            Further, by using the App you agree that Uppyx's remedy at law for any
                            actual or threatened breach of the intellectual property provisions herein
                            would be inadequate. As such, Uppyx shall be entitled to specific
                            performance, injunctive relief, or both, in addition to any damages Uppyx
                            may be entitled to recover, along with reasonable expenses incurred by
                            Uppyx for any form of dispute resolution, including, without limitation,
                            reasonable attorneys' fees. No right or remedy of Uppyx shall be exclusive
                            of any other, whether at law or in equity, including without limitation
                            damages, injunctive relief, attorneys' fees and expenses. No instance of
                            waiver by Uppyx of its rights or remedies under this Agreement shall imply
                            any obligation to grant any similar, future, or other waiver. No act or
                            omission by or on behalf of Uppyx is intended to be, nor should be
                            construed as, a waiver of any of its rights, claims, causes of action, or
                            remedies related to this Agreement.
                        </p>
                        <p class="font-policy">
                            <strong>INDEMNIFICATION</strong>
                        </p>
                        <p>
                            You agree to defend, indemnify and hold harmless Uppyx, its officers,
                            directors, and employees from any and all claims, liabilities, and costs,
                            including, but not limited to, attorneys' fees and expenses, arising from
                            or in connection with your use of the App or any service obtained therein,
                            including but not limited to the reservation, delivery, use, and return of
                            car rentals; or any violation of this Agreement, our Privacy Policy, or any
                            other policy posted from time to time on the App.
                        </p>
                        <p class="font-policy">
                            <strong>SEVERABILITY</strong>
                        </p>
                        <p>
                            If any provision of this Agreement is deemed void, invalid, or
                            unenforceable for any reason by any arbiter or court of competent
                            jurisdiction, then such provision shall be enforced to the maximum extent
                            possible under applicable law. All provisions of this Agreement are
                            severable, and shall not affect the validity or enforceability of the
                            remaining provisions.
                        </p>
                        <p class="font-policy">
                            <strong>ENTIRE AGREEMENT</strong>
                        </p>
                        <p>
                            These Terms and Conditions and other reference documents and policies
                            constitute the entire agreement between you and Uppyx, govern your use of
                            the App, and supersede prior agreements, written or oral, between you and
                            Uppyx. You may not assign this Agreement or any rights or obligations
                            hereunder, in whole or in part, voluntarily or by operation of law, without
                            prior written consent of Uppyx. Any purported assignment in contravention
                            of this paragraph shall be null and void. This Agreement does not confer
                            any third-party beneficiary rights. Agreements with third party providers
                            are separate from this Agreement. Uppyx's failure to enforce any right or
                            provision in this Agreement shall not constitute a waiver unless agreed to
                            by Uppyx in writing.
                        </p>
                        <p class="font-policy">
                            <strong>UPPYX CORP LLC ADDRESS</strong>
                        </p>
                        <p>
                            Please send any questions or comments regarding the Services to:
                        </p>
                        <p>
                            info@uppyx.com
                        </p>
                        <p>
                            Uppyx Corp.
                            <br/>
                            8400 NW 36th Street, Suite 450, Miami FL 33166
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection