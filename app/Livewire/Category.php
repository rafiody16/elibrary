<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category as Categories;

class Category extends Component
{
    public $name_category, $description, $id_category, $showModal = false;

    protected $listeners = [
        'deleteCategoryListener' => 'deleteCategory'
    ];

    protected $rules = [
        'name_category' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    public function render()
    {
        $categories = Categories::paginate(10);
        return view('livewire.category.category', compact('categories'));
    }

    public function resetFields()
    {
        $this->name_category = '';
        $this->description = '';
        $this->id_category = null;
    }

    public function addCategory()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function storeCategory()
    {
        $this->validate();
        try {
            Categories::create([
                'name_category' => $this->name_category,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Category added successfully.');
            $this->resetFields();
            $this->showModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add category: ' . $e->getMessage());
        }
    }

    public function editCategory($id)
    {
        $category = Categories::findOrFail($id);
        $this->name_category = $category->name_category;
        $this->description = $category->description;
        $this->id_category = $category->id_category;
        $this->showModal = true;
    }

    public function updateCategory()
    {
        $this->validate();
        try {
            $category = Categories::findOrFail($this->id_category);
            $category->update([
                'name_category' => $this->name_category,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Category updated successfully.');
            $this->resetFields();
            $this->showModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function cancelPost()
    {
        $this->resetFields();
        $this->showModal = false;
    }

    public function deleteCategory($id)
    {
        try {
            $category = Categories::findOrFail($id);
            $category->delete();

            session()->flash('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->showModal = false;
    }

    
}
