<div class="col-lg-12 text-center bgm-bluegray subheader"
     style="">
    Current Event:
    @if (GameEvents::currentEvent() != null)
        {{ GameEvents::currentEvent()->event->description }}
    @else
        No current event
    @endif
</div>