# ProgressBar

[![Packagist](https://img.shields.io/packagist/v/haythem/progress-bar.svg)](https://packagist.org/packages/haythem/)
[![Packagist](https://img.shields.io/packagist/l/haythem/progress-bar.svg)](https://packagist.org/packages/haythem/progress-bar)
[![Github All Releases](https://img.shields.io/github/downloads/haythembenkhlifa/progress-bar/total.svg)]()
[![Github Downloads (total)](https://img.shields.io/github/downloads/haythembenkhlifa/progress-bar/total.svg)]()

Package Description: A dynamic progress bar field for laravel nova

![](img/desktop.png)
![](img/mobile.png)

## Installation

Install via composer

```bash
composer require haythem/progress-bar
```

## Setup route

```
Route::get('/progressbar', function () {
    return ["percentage" => rand(0, 100), "show" => true];
});
```

## Usage

```php
    use Haythem\ProgressBar\ProgressBar;

    public function fields(Request $request)
    {
     return [
            ProgressBar::make('Progress Bar')
                ->endPoint('/api/progress')
                ->callEvery(500)
                ->markAsDone(false)
                ->barColor("#FFC0CB")
                ->barBackgroundColor("yellow")
                ->textColor('pink')
                ->initLabel("please wait")
                ->processingLabel("processing")
                ->doneLabel("all is good")
                ->redirectWhenItsDone("https://www.google.com",true)  //second parameter is optional to open the url in new tab or in the same tab
                ->reloadWhenItsDone()
                ->animation(),//show three dots animation when initializing and processing
    ];
    }
```
