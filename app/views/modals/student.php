<div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Program</h3>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Manage Student
                        </div>
                        <div class="panel-body">
                            <div class="row text-right">
                                <span style="color:red;">field(*) are required.</span>
                            </div>
                            <div class="row">
                            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" id="tabList">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a>
                    </li>

                    <li role="presentation">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">Personal Details</a>
                    </li>

                    <li role="presentation">
                        <a href="#education" aria-controls="education" role="tab" data-toggle="tab">Education</a>
                    </li>

                    <li role="presentation">
                        <a href="#cdetails" aria-controls="cdetails" role="tab" data-toggle="tab">Contact Details</a>
                    </li>
                </ul>

                <div class="tab-content">
                <br>
                    <div role="tabpanel" class=" tab-pane active" id="home">
                        <form role="form">
                            <div class="form-group col-md-6">
                                <label for="fname">First Name *</label>
                                <input id="studentId" type="hidden"/>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lname">Last Name *</label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" />
                                <span class="help-inline"></span>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="details">
                            <div class="form-group col-md-6">
                                <label for="programId">Program *</label>
                                <select class="form-control" id="programId" name="programId">
                                    <option data-no="-1" data-value='-1' value='-1' name="None">None</option>
                                    <?php
                                        foreach ($this->program as $value) {
                                    ?>
                                            <option data-no='<?= $value['noOfYearOrSemester'] ?>' data-value='<?= $value['id'] ?>' value="<?= $value['id'] ?>" name="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                                    <?php
                                         } 
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="yearOrSemester">Semester/Year *</label>
                                <select class="form-control" id="yearOrSemester" name="yearOrSemester">
                                    <option data-value='-1' value='-1' name="None">None</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sectionId">Section *</label>
                                <select class="form-control" id="sectionId" name="sectionId">
                                    <option data-value='-1' value='-1' name="None">None</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dobAd">Date of Birth (A.D) *</label>
                                <input type="date" class="form-control" name="dobAd" id="dobAd" placeholder="Date of Birth" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender *</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="-1"> Please Select </option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nationality">Nationality</label>
                                <input type="text" class="form-control" value="Nepali" name="nationality" id="nationality" placeholder="Nationality" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fatherName">Father's Name</label>
                                <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Father's Name" />
                                <span class="help-inline"></span>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="education">
                        <div class="form-group col-md-3">
                            <label for="level">Level *</label>
                            <select class="form-control" name="level" id="level">
                                <option value="1">SLC</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="board">Board *</label>
                            <input type="text" class="form-control" name="board" id="board" placeholder="Board" />
                            <span class="help-inline"></span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="faculty">Faculty</label>
                            <input type="text" class="form-control" name="faculty" id="faculty" placeholder="Faculty" />
                            <span class="help-inline"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="yearOfCompletion">Y.O.C *</label>
                            <input type="text" class="form-control" name="yearOfCompletion" id="yearOfCompletion" placeholder="Year of completion" />
                            <span class="help-inline"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="percent">Percent/GPA *</label>
                            <input type="text" class="form-control" name="percent" id="percent" placeholder="Percent/GPA" />
                            <span class="help-inline"></span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="institution">Institute *</label>
                            <input type="text" class="form-control" name="institution" id="institution" placeholder="Institute" />
                            <span class="help-inline"></span>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="cdetails">
                            <div class="form-group col-md-6">
                                <label for="municipality">Municipality *</label>
                                <input type="text" class="form-control" name="municipality" id="municipality" placeholder="Municipality" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="wardNo">Ward. NO *</label>
                                <input type="number" class="form-control" name="wardNo" id="wardNo" placeholder="Ward. NO" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="area">Area *</label>
                                <input type="text" class="form-control" name="area" id="area" placeholder="Area" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="district">District *</label>
                                <input type="text" class="form-control" name="district" id="district" placeholder="District" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zone">Zone *</label>
                                <input type="text" class="form-control" name="zone" id="zone" placeholder="Zone" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobileNo">Mobile No *</label>
                                <input type="text" class="form-control" name="mobileNo" id="mobileNo" placeholder="Mobile No" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telephoneNo">Telephone No</label>
                                <input type="text" class="form-control" name="telephoneNo" id="telephoneNo" placeholder="Telephone No" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email *</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianName">Guardian Name</label>
                                <input type="text" class="form-control" name="guardianName" id="guardianName" placeholder="Guardian Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianRelation">Guardian Relationship</label>
                                <input type="text" class="form-control" name="guardianRelation" id="guardianRelation" placeholder="Guardian Relationship" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianContact">Guardian Contact</label>
                                <input type="text" class="form-control" name="guardianContact" id="guardianContact" placeholder="Gurdian Contact" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="col-sm-6">&nbsp;</div>
                            <div class="form-group col-6 col-sm-6 text-right">
                                <a id="saveBtn" href="#" class="btn btn-success">Add</a>
                                <button class="btn btn-warning" data-dismiss="modal">Close</button>
                            </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <div class="form-group col-sm-6 text-left">
                    <a href="#" class="btn btn-primary previous">Previous</a>
                </div>
                <div class="form-group col col-sm-6 text-right">
                    <a href="#" class="btn btn-primary next">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>