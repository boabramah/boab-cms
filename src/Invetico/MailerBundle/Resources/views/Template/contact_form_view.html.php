

{% if flash.hasErrors() %}
    <span class=""> {{ flash.getErrors()}}</span>
{% endif %}
                    
{{ form_start(form, {'action': path('check_contact'), 'method': 'POST','attr': {'class': 'wpcf7-form', 'id': 'contact_form'}}) }}
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <span class="name">
                {{ form_widget(form.fullName,{ 'attr': {'class': 'form-controlxx'} }) }}
                    {% if flash.getError('fullName') %}
                    <span class="error">{{ flash.getError('fullName') }}</span>
                {% endif %}                                    
            </span><br/>
            <span class="subject">
                {{ form_widget(form.subject,{ 'attr': {'class': 'form-controlxx'} }) }}
                    {% if flash.getError('subject') %}
                    <span class="error">{{ flash.getError('subject') }}</span>
                {% endif %}
            </span>
        </div>  
        <div class="col-sm-6 col-xs-12">         
            <span class="email">
                {{ form_widget(form.email,{ 'attr': {'class': 'form-controlxx'} }) }}
                    {% if flash.getError('email') %}
                    <span class="error">{{ flash.getError('email') }}</span>
                {% endif %}
            </span><br/>
            <span class="telephone">
                {{ form_widget(form.contactNumber,{ 'attr': {'class': 'form-controlxx'} }) }}
                    {% if flash.getError('contact_number') %}
                    <span class="error">{{ flash.getError('contact_number') }}</span>
                {% endif %}
            </span>
        </div>
        <div class="col-sm-12 col-xs-12">
            <span class="comment">
                {{ form_widget(form.message,{ 'attr': {'class': 'form-controlxx','cols':40, 'rows':10} }) }}
                    {% if flash.getError('message') %}
                    <span class="error">{{ flash.getError('message') }}</span>
                 {% endif %}
            </span>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="captcha">
                <div class="captcha-wrapper">
                    {{ form_widget(form.captcha) }}
                       {% if flash.getError('captcha') %}
                        <span class="error">{{ flash.getError('captcha') }}</span>
                    {% endif %} 
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div id="subject">
                <input type="submit" id='send_message' value='Submit Form' class="btn btn-line" />
            </div>
        </div>
    </div>
{{ form_end(form ,{'attr': {'class': 'just-testing', 'id': 'submit'}}) }}

