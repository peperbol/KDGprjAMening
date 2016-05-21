using UnityEngine;
using System.Collections;
using UnityEngine.EventSystems;
using System.Linq;

public class CommentInput : MonoBehaviour {

    RectTransform rectTransform;
	void Start () {
        rectTransform = GetComponent<RectTransform>();
    }
	
    float Position {
        get {
            return rectTransform.pivot.y;
        }
        set {
            rectTransform.pivot = new Vector2(rectTransform.pivot.x, Mathf.Clamp(value, 0,1));
        }
    }

	void Update () {


        RaycastHit hit;
        if (Input.touchCount > 0 && (Input.touches[0].phase == TouchPhase.Moved)  && Physics.Raycast(Camera.main.ScreenPointToRay(Input.touches[0].position), out hit) && hit.collider.gameObject == gameObject)
        {
            Touch t = Input.GetTouch(0);


            Vector3[] corners = new Vector3[4];
            rectTransform.GetWorldCorners(corners);

            Debug.Log(/*Camera.current.ScreenToWorldPoint(t.position)+*/ " " + t.position);
            Position += (Camera.current.ScreenToWorldPoint(t.position + t.deltaPosition).y - Camera.current.ScreenToWorldPoint(t.position).y) / (corners.Max(e => e.y) - corners.Min(e => e.y));
        }
    }
}
