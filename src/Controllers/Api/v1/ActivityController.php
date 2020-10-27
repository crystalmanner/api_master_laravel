<?php

namespace FreshinUp\ActivityApi\Controllers\Api\v1;

use FreshinUp\ActivityApi\Actions\CreateActivity;

use FreshinUp\ActivityApi\Models\Note;
use FreshinUp\ActivityApi\Http\Requests\ActivityNoteAddRequest;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Resources\ActivityResource;
use FreshinUp\ActivityApi\Resources\NoteResource;
use FreshinUp\ActivityApi\Sorts\CustomerEmailSort;
use FreshinUp\ActivityApi\Sorts\SaleRepEmailSort;
use FreshinUp\ActivityApi\Sorts\TypeNameSort;
use FreshinUp\FreshBusForms\Filters\GreaterThanOrEqualTo;
use FreshinUp\FreshBusForms\Filters\LessThanOrEqualTo;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Sort;

class ActivityController extends Controller
{
    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, CreateActivity $action)
    {
        $activity = $action->execute($request->all());
        return response()->json($activity);
    }

    /**
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $activities = QueryBuilder::for(Activity::class, $request)
            ->allowedSorts([
                "scheduled_at",
                "status_id",
                Sort::custom("customer_email", new CustomerEmailSort()),
                Sort::custom("type_name", new TypeNameSort()),
                Sort::custom("salesrep_email", new SaleRepEmailSort())
            ])
            ->allowedFilters([
                Filter::exact('deal_uuid', 'deals_deal_uuid'),
                'status_id',
                'type_id',
                'salesrep_uuid',
                'customer_uuid',
                Filter::custom('scheduled_at_before', LessThanOrEqualTo::class, 'scheduled_at'),
                Filter::custom('scheduled_at_after', GreaterThanOrEqualTo::class, 'scheduled_at'),
            ]);
        return ActivityResource::collection($activities->jsonPaginate(30));
    }

    public function destroy($uuid)
    {
        $count = Activity::where('uuid', $uuid)->delete();
        if ($count > 0) {
            return response()->json(['success' => true], 204);
        }
        return response()->json(['success' => false], 404);
    }

    public function show($uuid)
    {
        $activity = Activity::where('uuid', $uuid)->with('notes')->firstOrFail();
        return new ActivityResource($activity);
    }

    public function update(Request $request, $uuid)
    {
        $payload = $request->only('title', 'activity_reminder_unity_id', 'activity_reminder_quantity', 'days');
        /** @var User $authUser */
        $authUser = Auth::user();
        // isPlatformAdmin
        if ($authUser && $authUser->level == 8) {
            $payload = array_merge($payload, $request->only('type_id', 'scheduled_at'));
        }
        /** @var Activity $activity */
        $activity = Activity::where('uuid', $uuid)->firstOrFail();
        $activity->update($payload);
        return new ActivityResource($activity);
    }

    public function storeNotes(ActivityNoteAddRequest $request, $uuid)
    {
        $activity = Activity::where('uuid', $uuid)->firstOrFail();
        $payload = $request->only('text');
        if ($request->has('status_id')) {
            $payload['status_name'] = Status::findOrFail($request->input('status_id'))->name;
        }
        $note = $activity->notes()->create($payload);
        return new NoteResource($note);
    }

    public function updateNotes(Request $request, $activity_uuid)
    {
        $note = Note::where('activity_uuid', $activity_uuid)->first();
        $note->status_name = $request->status_name;
        $note->text = $request->text;
        $note->save();

        return new NoteResource($note);
    }
}
