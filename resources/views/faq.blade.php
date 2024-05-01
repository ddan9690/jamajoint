@extends('frontend.layout.master')
@section('title', 'JamaJoint :: FAQ')

@section('content')

<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="section-title position-relative mb-4 pb-2 text-center">
                    <h6 class="position-relative text-primary ps-4">Frequently Asked Questions</h6>
                    <h2 class="mt-2">Find Answers to Common Questions</h2>
                </div>
                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>What is JamaJoint?</strong>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint is an innovative platform that simplifies joint exam analysis. It offers easy data entry, comprehensive reporting, and insightful analysis on school, stream, and student performance.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>How does JamaJoint work?</strong>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint streamlines exam analysis with user-friendly features. You can create exams, input marks, and publish results effortlessly. Comprehensive reports provide valuable insights into school, stream, and student performance.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <strong>What kind of insights does JamaJoint provide?</strong>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint offers detailed insights into school ranking, stream analysis, overall student ranking, and paper-wise analysis. These insights help you identify areas of improvement and optimize teaching strategies. All these detailed reports are available online and can be downloaded for offline viewing, allowing you to access the information at your convenience.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <strong>How confidential are our results?</strong>
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint places great emphasis and premium on privacy and security. The results of your exam or joint are only visible to the teachers whose schools participated in that particular exam. We strive to ensure the highest levels of data security and confidentiality for all our users.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <strong>What is the cost of using JamaJoint?</strong>
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                While our primary focus is not on financial gain, we ask for a small fee depending on several factors such as the number of schools participating in the joint exam and the number of students involved. This fee is mainly for system maintenance. Please contact us at 0711317235 so that we can discuss your specific needs and agree on what is best.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <strong>What subjects does JamaJoint analyze?</strong>
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint currently provides analysis for subjects with Paper 1 and Paper 2, averaging the scores based on the two papers. The platform is in the process of improving to accommodate subjects with three papers. Individual analysis for each paper is possible, but averaging across all three papers is not currently supported.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <strong>Why choose JamaJoint?</strong>
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We invite you to give JamaJoint a try for your joint exams. The slow, tedious, and error-prone Excel analysis is now a thing of the past. With JamaJoint, teachers can input their results online immediately after marking, and organizers can publish the results within minutes of mark submission. This means that results are available right away, eliminating the need to wait for hours or even days as Excel analysis is done. Experience the efficiency and accuracy of JamaJoint for your next joint exam.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                <strong>Does JamaJoint require special expertise or training?</strong>
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                JamaJoint is designed to be simple and user-friendly. All that is needed is a smartphone with internet access. No special knowledge or training is required, as everything is automated and straightforward. Additionally, we are always available for support if and when needed.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
