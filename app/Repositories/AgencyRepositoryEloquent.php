<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AgencyRepository;
use App\Entities\Agency;
use App\Validators\AgencyValidator;

use App\Entities\Role;

/**
 * Class AgencyRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AgencyRepositoryEloquent extends BaseRepository implements AgencyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Agency::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return AgencyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Create agency, along with contact and owner user, with the given attributes.
     *
     * @param array $attributes
     * @return Agency
     */
    public function create(array $attributes)
    {
        $data = [
            'name' => $attributes['agency_name'],
            'active' => true,
            'legal' => ''
        ];

        $agency = parent::create($data);
        $attributes = array_merge(['agency_id' => $agency->id], $attributes);

        $contact_repo = app('App\Repositories\ContactRepository');
        $contact = $contact_repo->createFromAgency($attributes);

        $user_repo = app('App\Repositories\UserRepository');
        $owner = $user_repo->createOwnerFromAgency($attributes);

        return $agency;
    }

    /**
     * Toggle active/inactive status of given Agency.
     *
     * @param $id
     * @return Agency
     */
    public function active($id)
    {
        $agency = Agency::find($id);

        // Ensure no Super or CSR are currently ghosting. If they are, reassign them to agency 1.
        $super_role = Role::where('name', 'super')->first();
        $supers = $super_role->users()->where('agency_id', $agency->id)->get();

        foreach ($supers as $super) {
            $super->agency_id = 1;
            $super->save();
        }

        $csr_role = Role::where('name', 'super')->first();
        $csrs = $csr_role->users()->where('agency_id', $agency->id)->get();

        foreach ($csrs as $csr) {
            $csr->agency_id = 1;
            $csr->save();
        }

        if ($agency->active) {
            $agency->active = false;
        } else {
            $agency->active = true;
        }

        $agency->save();

        return $agency;
    }

    /**
     * Update Agency, including contact information, with the given attributes.
     * If defined, transfer ownership of Agency from one user to another.
     *
     * @param array $attributes
     * @param $id
     * @return Array
     */
    public function update(array $attributes, $id)
    {
        $agency = Agency::find($id);
        $agency->name = $attributes['agency_name'];
        $agency->legal = $attributes['agency_legal'];
        $agency->nielsen_secret = $attributes['agency_nielsen_secret'] !== '' ? trim($attributes['agency_nielsen_secret']) : null;
        if(isset($attributes['agency_nielsen_tv'])){
            $agency->nielsen_tv = true;
        }else{
            $agency->nielsen_tv = false;
        }
        if(isset($attributes['agency_nielsen_radio'])){
            $agency->nielsen_radio = true;
        }else{
            $agency->nielsen_radio = false;
        }
        $agency->save();

        $contact = $agency->contact()->first();
        $contact_repo = app('App\Repositories\ContactRepository');



        $data = [
            'address_line_1' => $attributes['agency_address_line_1'],
            'address_line_2' => $attributes['agency_address_line_2'],
            'city' => $attributes['agency_address_city'],
            'region' => $attributes['agency_address_region'],
            'postal_code' => $attributes['agency_address_postal_code'],
            'nation' => $attributes['agency_address_nation'],
            'phone' => $attributes['agency_phone'],
            'fax' => $attributes['agency_fax'],
            'email' => $attributes['agency_email'],
            'website' => $attributes['agency_website']
        ];

        $contact_repo->update($data, $contact->id);

        if (isset($attributes['agency_owner'])) {
            $user_repo = app('App\Repositories\UserRepository');
            $owner_role = Role::where('name', 'owner')->first();
            $new_owner = $user_repo->findWhere([['id', '=', $attributes['agency_owner']]])->first();
            $existing_owner = $owner_role->users()->where('agency_id', $agency->id)->first();

            if ($new_owner->id != $existing_owner->id) {
                $new_owner->roles()->sync([]);
                $new_owner->attachRole($owner_role);

                $existing_owner->roles()->sync([]);
                $existing_owner->attachRole(Role::where('name', 'admin')->first());
            }
        }

        return $agency;
    }

    /**
     * Delete the given Agency and all associated entities.
     *
     * @param $id
     * @return Agency
     */
    public function delete($id)
    {
        $agency = Agency::find($id);

        // Ensure no Super or CSR are currently ghosting. If they are, reassign them to agency 1.
        $super_role = Role::where('name', 'super')->first();
        $supers = $super_role->users()->where('agency_id', $agency->id)->get();

        foreach ($supers as $super) {
            $super->agency_id = 1;
            $super->save();
        }

        $csr_role = Role::where('name', 'super')->first();
        $csrs = $csr_role->users()->where('agency_id', $agency->id)->get();

        foreach ($csrs as $csr) {
            $csr->agency_id = 1;
            $csr->save();
        }

        $user_repo = app('App\Repositories\UserRepository');
        foreach ($agency->users as $user) {
            $user_repo->delete($user->id);
        }

        $contact_repo = app('App\Repositories\ContactRepository');
        foreach ($agency->contact as $contact) {
            $contact_repo->delete($contact->id);
        }

        return parent::delete($id);
    }

    /**
     * Find and return the first agency with the defined slug.
     *
     * @param $slug
     * @return Agency
     */
    public function findBySlug($slug)
    {
        return Agency::where('slug', $slug)->first();
    }
}
