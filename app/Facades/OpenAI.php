<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use OpenAI\Resources\Audio;
use OpenAI\Resources\Chat;
use OpenAI\Resources\Completions;
use OpenAI\Resources\Edits;
use OpenAI\Resources\Embeddings;
use OpenAI\Resources\Files;
use OpenAI\Resources\FineTunes;
use OpenAI\Resources\Images;
use OpenAI\Resources\Models;
use OpenAI\Resources\Moderations;

/**
 * @method static Audio audio()
 * @method static Chat chat()
 * @method static Completions completions()
 * @method static Embeddings embeddings()
 * @method static Edits edits()
 * @method static Files files()
 * @method static FineTunes fineTunes()
 * @method static Images images()
 * @method static Models models()
 * @method static Moderations moderations()
 */
final class OpenAI extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'openai';
    }
}
