using UnityEngine;
using System.Collections;

[RequireComponent(typeof(RectTransform))]
public class OverlaySlider : MonoBehaviour {
    public bool visisble;
    public float tweenSpeed = 0.2f;
    public float invisiblePosition = -1;

    private float visiblePosition = 0;
    private float position;
    private RectTransform rect;

    private float Position { get { return position; }
        set {
            position = value;
            rect.anchorMin = new Vector2(rect.anchorMin.x, position);
            rect.anchorMax = new Vector2(rect.anchorMax.x, position + 1);
        }
    }
	void Start () {
        rect = GetComponent<RectTransform>();
        Position = (visisble) ? visiblePosition : invisiblePosition;
	}

	void Update () {
        Position = Position + (((visisble) ? visiblePosition : invisiblePosition) - Position) * tweenSpeed;
	}
}
