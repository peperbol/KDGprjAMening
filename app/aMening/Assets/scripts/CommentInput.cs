using UnityEngine;
using System.Collections;
using UnityEngine.EventSystems;
using System.Linq;
/// <summary>
/// handles all swipe input and position of the comment section
/// </summary>
public class CommentInput : MonoBehaviour {

    public float speedDecay = 0.2f;
    public float tabSpeed = 5;
    public float headerHeight = 85;
    public GameObject upArrow;
    public GameObject downArrow;
    public float topMargin = 0.05f;

    private Vector2 touchY;
    private float speed;
    private bool moved;
    private RectTransform rectTransform;

    void Start () {
        rectTransform = GetComponent<RectTransform>();
    }
	
    float Position {
        get {
            return 1- rectTransform.pivot.y;
        }
        set {
            var cachedHeight = Heigth;
            if (cachedHeight > 0)
            {
                float max = 1 - headerHeight / cachedHeight;
                rectTransform.pivot = new Vector2(rectTransform.pivot.x, 1 - Mathf.Clamp(value, 0, max));

                upArrow.SetActive(value < max - topMargin);
                downArrow.SetActive(value >= max - topMargin);
            }
        }
    }
    public float Heigth {
        get
        {
            Vector3[] corners = new Vector3[4];
            rectTransform.GetWorldCorners(corners);

            return corners.Max(e => e.y) - corners.Min(e => e.y);
        }
    }

    public void Open()
    {
        speed = tabSpeed;
    }
    public void Close()
    {

        speed = -tabSpeed;
    }

    void Update () {
        
        RaycastHit hit;
        if (Input.touchCount > 0 && Physics.Raycast(Camera.main.ScreenPointToRay(Input.touches[0].position), out hit) && hit.collider.gameObject == gameObject)
        {
            if ((Input.GetTouch(0).phase == TouchPhase.Moved)|| (Input.GetTouch(0).phase == TouchPhase.Stationary))
            {
                Touch t = Input.GetTouch(0);


                speed = (Camera.main.ScreenToWorldPoint(t.position).y - Camera.main.ScreenToWorldPoint(touchY).y) / Heigth;
                Position += speed;
                speed /= Time.deltaTime;
                Debug.Log(speed);
                touchY = Input.GetTouch(0).position;
                moved |= (Input.GetTouch(0).phase == TouchPhase.Moved);
            } else if ((Input.GetTouch(0).phase == TouchPhase.Began))
            {
                touchY = Input.GetTouch(0).position;
                speed = 0;
                moved = false;
            }
            else if ((Input.GetTouch(0).phase == TouchPhase.Ended) && !moved)
            {
                Debug.Log(Position);
                if(Position < 1 - headerHeight/Heigth - 0.005f - topMargin)
                    Open();
                else{
                    
                    Close();
                }
            }
        }
        else
        {
            speed *= 1  - speedDecay;

            Position += speed* Time.deltaTime;
            
        }
    }
}
