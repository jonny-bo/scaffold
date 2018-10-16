<?php namespace Modules\Setting\Repositories;

use Modules\Setting\Models\Setting;
use App\Scaffold\BaseRepository;
use Modules\Setting\Bundles\AbstractBundle;
use Prettus\Repository\Exceptions\RepositoryException;

class SettingRepository extends BaseRepository
{
    /**
     * @var [
     *          key=>value,
     *          key=>value,
     *      ] Array
     */
    private static $systemSettings = null;

    /**
     * @var  array
     */
    protected $fieldSearchable = [
        "name",
        "value",
        "settable_id",
        "settable_type"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }

    /**
     * Get a setting bundle
     * @no-permission
     * @param AbstractBundle $bundle
     * @param bool $default
     * @return AbstractBundle
     */
    public function getBundle(AbstractBundle $bundle, $default = false)
    {
        if ($default) {
            return $bundle;
        }
        $query = $this->getNewQuery();
        $query = $bundle->makeQueryFiltered($query);
        $settings = $query->pluck('value', 'name');
        $bundle->setEnableSetter(false);
        $bundle->load($settings);
        $bundle->setEnableSetter(true);
        return $bundle;
    }

    /**
     * Put a bundle into Persistence saving
     * @no-permission
     * @param AbstractBundle $bundle
     */
    public function setBundle(AbstractBundle $bundle)
    {
        $data = $bundle->getValues();
        foreach ($data as $name => $value) {
            $query = $this->getNewQuery();
            $query = $bundle->makeQueryFiltered($query);
            $setting = $query->firstOrNew(['name' => $name]);
            $setting->value = $value;
            $setting->save();
        }
    }

    /**
     * Update the $name $value of the $bundle
     * @no-permission
     * @param AbstractBundle $bundle
     * @param $name
     * @param $value
     * @return
     */
    public function updateByBundle(AbstractBundle $bundle, $name, $value)
    {
        $query = $this->getNewQuery();
        $query = $bundle->makeQueryFiltered($query);
        return $query->where('name', '=', $name)->update(['value' => $value]);
    }

    /**
     * Get a setting record model object
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getItem($name)
    {
        return $this->getNewQuery()->where('name', '=', $name)->first();
    }

    /**
     * Get a setting record value
     * @param $name
     * @param $default
     * @return mixed
     */
    public function getItemValue($name, $default)
    {
        $item = $this->getItem($name);
        if ($item) {
            return $item->value;
        }
        return $default;
    }

    /**
     * Set a setting record value
     * @param $name
     * @param $value
     */
    public function setItemValue($name, $value)
    {
        $item = $this->getItem($name);
        if ($item) {
            $item->value = $value;
            $item->save();
        }
    }

    /**
     *
     * @no-permission
     */
    public function getNewQuery()
    {
        try {
            $query = $this->makeModel()->newQuery();
        } catch (RepositoryException $e) {
            $query = Setting::query();
        }
        return $query;
    }
}
