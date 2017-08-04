

                        {{ form_start(form, {'action': path('check_contact'), 'method': 'POST','attr': {'class': 'just-testing', 'id': 'contact-form'}}) }}
                                <div class="form-group col-sm-6">
                                       {{ form_widget(form.fullName,{ 'attr': {'class': 'form-control'} }) }}                                   
                                </div>
                                <div class="form-group col-sm-6">
                                          {{ form_widget(form.email,{ 'attr': {'class': 'form-control'} }) }}
                                </div>
                                <div class="form-group col-sm-12">
                                          {{ form_widget(form.subject,{ 'attr': {'class': 'form-control'} }) }}
                                </div>
                                <div class="form-group col-sm-12 ">
                                       {{ form_widget(form.message,{ 'attr': {'class': 'form-control'} }) }}
                                </div>
                                <div class="col-sm-12 captcha">
                                       {{ form_widget(form.captcha) }} 
                                </div>
                                <div class="col-sm-12 button submit-contact-container">
                                    <input type="submit" id="submit-contact" class="btn" value="Send Message">
                                </div>
                        {{ form_end(form ,{'attr': {'class': 'just-testing', 'id': 'submit'}}) }}

