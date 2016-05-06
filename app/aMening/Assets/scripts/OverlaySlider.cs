using UnityEngine;
using System.Collections;
[RequireComponent(typeof(RectTransform))]
public class OverlaySlider : MonoBehaviour {
    public bool visisble;
    public float tweenspeed = 0.2f;
    private float visiblePosition = 0;
    public float invisiblePosition = -1;
    private float position;
    private float Position { get { return position; }
        set {
            position = value;
            rect.anchorMin = new Vector2(rect.anchorMin.x, position);
            rect.anchorMax = new Vector2(rect.anchorMax.x, position + 1);
        }
    }
    private RectTransform rect;
	void Start () {
        rect = GetComponent<RectTransform>();
        Position = (visisble) ? visiblePosition : invisiblePosition;
	}

	void Update () {
        Position = Position + (((visisble) ? visiblePosition : invisiblePosition) - Position) * tweenspeed;
	}
}
