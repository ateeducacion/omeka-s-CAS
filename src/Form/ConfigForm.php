<?php

/*
 * Copyright 2020 BibLibre
 *
 * This file is part of CAS.
 *
 * CAS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CAS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CAS.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace CAS\Form;

use Laminas\Form\Form;

class ConfigForm extends Form
{
    public function init()
    {
        // CAS Server URL (main configuration)
        $this->add([
            'type' => 'Text',
            'name' => 'url',
            'options' => [
                'label' => 'URL', // @translate
                'info' => 'URL of the CAS server', // @translate
            ],
            'attributes' => [
                'id' => 'url',
                'required' => true,
            ],
        ]);

        //User role to assign to created users (main configuration)
        $this->add([
            'type' => 'Omeka\Form\Element\RoleSelect',
            'name' => 'role',
            'options' => [
                'label' => 'Role', // @translate
                'info' => 'Created users will have this role', // @translate
            ],
            'attributes' => [
                'id' => 'role',
                'required' => true,
            ],
        ]);
        // User attribute mapping fields
        $this->add([
            'type' => 'Text',
            'name' => 'user_id_attribute',
            'options' => [
                'label' => 'Attribute used as identifier', // @translate
                'info' => 'If set, this attribute will be used as the unique user identifier to find the corresponding Omeka S user account', // @translate
            ],
            'attributes' => [
                'id' => 'user_id_attribute',
                'required' => false,
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'user_name_attribute',
            'options' => [
                'label' => 'Attribute used as user name', // @translate
                'info' => 'If set, this attribute will be used as the user name when creating a new Omeka S user account', // @translate
            ],
            'attributes' => [
                'id' => 'user_name_attribute',
                'required' => false,
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'user_email_attribute',
            'options' => [
                'label' => 'Attribute used as user email', // @translate
                'info' => 'If set, this attribute will be used as the user email when creating a new Omeka S user account', // @translate
            ],
            'attributes' => [
                'id' => 'user_email_attribute',
                'required' => false,
            ],
        ]);

        $this->add([
            'type' => 'Checkbox',
            'name' => 'create_user_on_login',
            'options' => [
                'label' => 'Create user account on login', // @translate
                'info' => 'If checked, a new Omeka S user account will be created automatically when a CAS user logs in for the first time. If unchecked, only existing users can log in via CAS.', // @translate
            ],
            'attributes' => [
                'id' => 'create_user_on_login',
                'required' => false,
            ],
        ]);


        $this->add([
            'type' => 'Checkbox',
            'name' => 'update_user_on_login',
            'options' => [
                'label' => 'Update user attributes on login', // @translate
                'info' => 'If checked, user name and email will be updated from the CAS attributes configured above (user name attribute and user email attribute) on every login. Only attributes that are not null will be updated.', // @translate
            ],
            'attributes' => [
                'id' => 'update_user_on_login',
                'required' => false,
            ],
        ]);

        $this->add([
            'type' => 'Checkbox',
            'name' => 'show_login_link_in_user_bar',
            'options' => [
                'label' => 'Show CAS login link in user bar', // @translate
            ],
            'attributes' => [
                'id' => 'show_login_link_in_user_bar',
                'required' => false,
            ],
        ]);


        $this->add([
            'type' => 'Checkbox',
            'name' => 'global_logout',
            'options' => [
                'label' => 'Enable CAS global logout', // @translate
                'info' => 'Redirect local logouts to CAS to terminate the global session.', // @translate
            ],
            'attributes' => [
                'id' => 'global_logout',
                'required' => false,
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'logout_redirect_service',
            'options' => [
                'label' => 'Logout redirect service URL', // @translate
                'info' => 'Optional URL the CAS server should redirect to after logout. Defaults to the Omeka S homepage.', // @translate
            ],
            'attributes' => [
                'id' => 'logout_redirect_service',
                'required' => false,
            ],
        ]);
    }
}
